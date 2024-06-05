import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor, UpperCasePipe } from '@angular/common';

import { jsPDF } from 'jspdf'; 
import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';

@Component({
  selector: 'app-stock',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule, NgFor, UpperCasePipe],
  templateUrl: './stock.component.html',
  styleUrl: './stock.component.css'
})
export class StockComponent implements OnInit {
  data: any[] = [];
  filteredData: any[] = [];
  totalArticulos: number = 0;
  isSecondSelectEnabled: boolean = false;
  secondSelectOptions: string[] = [];
  filterType: string = '';

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.getTotalArticulos();

    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/accesorios/index').subscribe((data: any[]) => {
      this.data = data;
      this.filteredData = data;
    });
  }

  getTotalArticulos() {
    this.http.get('http://127.0.0.1:8000/api/auth/accesorios/getTotal').subscribe((data: any) => {
      this.totalArticulos = data.total;
    });
  }

  onFilterChange(event: any) {
    const value = event.target.value;
    this.filterType = value;
    this.isSecondSelectEnabled = !!value;

    if (value === 'marca') {
      this.secondSelectOptions = Array.from(new Set(this.data.map(item => item.marca)));
    } else if (value === 'articulo') {
      this.secondSelectOptions = Array.from(new Set(this.data.map(item => item.articulo)));
    } else {
      this.secondSelectOptions = [];
      this.filteredData = this.data; // Reset filteredData when "Sin filtro" is selected
    }
  }

  onFilterValueChange(event: any) {
    const value = event.target.value;
    if (!value) {
      this.filteredData = this.data; // Reset filteredData when no option is selected
      return;
    }
    
    if (this.filterType === 'marca') {
      this.filteredData = this.data.filter(item => item.marca === value);
    } else if (this.filterType === 'articulo') {
      this.filteredData = this.data.filter(item => item.articulo === value);
    } else {
      this.filteredData = this.data;
    }
  }

  downloadAsExcel() {
    const ws: XLSX.WorkSheet = XLSX.utils.json_to_sheet(this.filteredData); // Use filteredData instead of data
    const wb: XLSX.WorkBook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'tablastock');
    XLSX.writeFile(wb, 'inventario.xlsx');
  }

  downloadAsPdf() {
    const doc = new jsPDF();
    autoTable(doc, { html: '#data-table' });  // Use the id of your table element
    doc.save('inventario.pdf');
  }
}
