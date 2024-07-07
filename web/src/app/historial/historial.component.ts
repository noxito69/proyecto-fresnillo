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
  allFilteredHistorial: any[] = [];

  selectedFolio: string = '';
  selectedCentroCosto: string = '';
  selectedDepartamento: string = '';
  selectedFecha: string = '';
  selectedClaveEmpleado: string = '';

  centroCostoEnabled: boolean = true;
  departamentoEnabled: boolean = true;

  page: number = 1;
  pageSize: number = 5;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;

  constructor(private http: HttpClient, private router: Router) { }

  ngOnInit(): void {
    this.getHistorial();
  }

  getHistorial() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get<any>('http://127.0.0.1:8000/api/auth/historial/index' + params).subscribe((response: any) => {
      this.historial = response.data;
      this.filteredHistorial = response.data;
      this.totalItems = response.total;
      this.totalPages = response.last_page;
      this.currentPage = response.current_page;
      this.centroCostoOptions = Array.from(new Set(response.data.map((item: any) => item.centro_costos)));
      this.departamentoOptions = Array.from(new Set(response.data.map((item: any) => item.departamento)));
      this.folioOptions = Array.from(new Set(response.data.map((item: any) => item.id)));
    });
  }

  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getHistorial();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getHistorial();
    }
  }

  goToPage(page: number) {
    this.page = page;
    this.getHistorial();
  }

  get pages(): number[] {
    const half = Math.floor(this.pageSize / 2);
    let start = Math.max(this.currentPage - half, 1);
    let end = Math.min(start + this.pageSize - 1, this.totalPages);

    if (end - start < this.pageSize - 1) {
      start = Math.max(end - this.pageSize + 1, 1);
    }

    const pages = [];
    for (let i = start; i <= end; i++) {
      pages.push(i);
    }
    return pages;
  }

  onFolioChange(event: any) {
    this.selectedFolio = event.target.value;
    if (this.selectedFolio === 'none') {
      this.filteredHistorial = this.historial
    }

    const filter = this.filteredHistorial.filter(item => item.id === parseInt(this.selectedFolio))

    this.filteredHistorial = filter
  }

  onCentroCostoChange(event: any) {
    this.selectedCentroCosto = event.target.value;
    if (this.selectedCentroCosto === 'none') {
      this.selectedCentroCosto = '';
      this.departamentoEnabled = true;
    } else {
      this.departamentoEnabled = false;
      const filter = this.filteredHistorial.filter(item => item.centro_costos === this.selectedCentroCosto)

      this.filteredHistorial = filter
    }
  }

  onDepartamentoChange(event: any) {
    this.selectedDepartamento = event.target.value;
    if (this.selectedDepartamento === 'none') {
      this.selectedDepartamento = '';
      this.centroCostoEnabled = true;
    } else {
      this.centroCostoEnabled = false;

      const filter = this.filteredHistorial.filter(item => item.departamento === this.selectedDepartamento)

      this.filteredHistorial = filter
    }
  }

  onFechaChange(event: any) {
    this.selectedFecha = event.target.value;

    const filter = this.filteredHistorial.filter(item => this.formatDate(item.created_at) === this.formatDate(this.selectedFecha))

    this.filteredHistorial = filter
  }

  onClaveEmpleadoChange() {
    const filter = this.filteredHistorial.filter(item => item.num_empleado === this.selectedClaveEmpleado)

    this.filteredHistorial = filter
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
