import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { CommonModule, NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Router } from '@angular/router';
import { MatPaginator, PageEvent } from '@angular/material/paginator';

@Component({
  selector: 'app-historial',
  standalone: true,
  imports: [LayoutComponent, CommonModule, NgFor, HttpClientModule, FormsModule],
  templateUrl: './historial.component.html',
  styleUrls: ['./historial.component.css']
})
export class HistorialComponent implements OnInit {


  
  historial: any[] = [];
  filteredHistorial: any[] = [];
  centroCostoOptions: string[] = [];
  departamentoOptions: string[] = [];
  folioOptions: string[] = [];

  selectedFolio: string = '';
  selectedCentroCosto: string = '';
  selectedDepartamento: string = '';
  selectedFecha: string = '';
  selectedClaveEmpleado: string = '';

  centroCostoEnabled: boolean = true;
  departamentoEnabled: boolean = true;
  
  pageIndex: number = 0;
  pageSize: number = 15;

  

  

  constructor(private http: HttpClient, private router: Router) { }

  ngOnInit(): void {
    this.getHistorial();
  }

  getHistorial() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/historial/index').subscribe((data: any[]) => {
      this.historial = data;
      this.filteredHistorial = data;
      this.centroCostoOptions = Array.from(new Set(data.map(item => item.centro_costos)));
      this.departamentoOptions = Array.from(new Set(data.map(item => item.departamento)));
      this.folioOptions = Array.from(new Set(data.map(item => item.id)));
    });
  }

  onPageChange(page: number) {
    this.pageIndex = page;
    this.filterHistorial();
}

getPageNumbers(): number[] {
  const pageCount = Math.ceil(this.filteredHistorial.length / this.pageSize);
  return Array(pageCount).fill(0).map((x, i) => i);
}

  onFolioChange(event: any) {
    this.selectedFolio = event.target.value;
    if (this.selectedFolio === 'none') {
      this.selectedFolio = '';
    }
    this.filterHistorial();
  }

  onCentroCostoChange(event: any) {
    this.selectedCentroCosto = event.target.value;
    if (this.selectedCentroCosto === 'none') {
      this.selectedCentroCosto = '';
      this.departamentoEnabled = true;
    } else {
      this.departamentoEnabled = false;
    }
    this.filterHistorial();
  }

  onDepartamentoChange(event: any) {
    this.selectedDepartamento = event.target.value;
    if (this.selectedDepartamento === 'none') {
      this.selectedDepartamento = '';
      this.centroCostoEnabled = true;
    } else {
      this.centroCostoEnabled = false;
    }
    this.filterHistorial();
  }

  onFechaChange(event: any) {
    this.selectedFecha = event.target.value;
    this.filterHistorial();
  }

  onClaveEmpleadoChange() {
    this.filterHistorial();
  }

  filterHistorial() {
    this.filteredHistorial = this.historial.filter(item =>
      (!this.selectedCentroCosto || item.centro_costos === this.selectedCentroCosto) &&
      (!this.selectedDepartamento || item.departamento === this.selectedDepartamento) &&
      (!this.selectedFolio || item.id.toString() === this.selectedFolio) &&
      (!this.selectedFecha || this.formatDate(item.created_at) === this.selectedFecha) &&
      (!this.selectedClaveEmpleado || item.num_empleado.toString().includes(this.selectedClaveEmpleado))
    );


        const startIndex = this.pageIndex * this.pageSize;
        this.filteredHistorial = this.filteredHistorial.slice(startIndex, startIndex + this.pageSize);
  }

  formatDate(fechaISO: string): string {
    const fecha = new Date(fechaISO);
    return fecha.toISOString().split('T')[0];
  }

  isoDateToFormattedWithTime(fechaISO: string): string {
    const fecha = new Date(fechaISO);
    const mes = fecha.getMonth() + 1;
    const anio = fecha.getFullYear();
    const fechaFormateada = `${fecha.getDate().toString().padStart(2, '0')}/${mes.toString().padStart(2, '0')}/${anio}`;
    return fechaFormateada;
  }
}
