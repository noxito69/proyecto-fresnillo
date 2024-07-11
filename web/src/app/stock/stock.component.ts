import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor, UpperCasePipe } from '@angular/common';

import { jsPDF } from 'jspdf'; 
import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-stock',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule, NgFor, UpperCasePipe, FormsModule],
  templateUrl: './stock.component.html',
  styleUrl: './stock.component.css'
})
export class StockComponent implements OnInit {

  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();


  stock: any[] = [];
  articulos: any[] = [];
  totalArticulos: number = 0;


  page: number = 1;
  pageSize: number = 20;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;

  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getArticulos();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getArticulos();
    }
  }

  constructor(private http: HttpClient) {}



  ngOnInit(): void {
    this.getTotalArticulos();

    this.getStock(); 
    this.getArticulos();

    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.articulos= results.data;
    })
    
  }

  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/accesorios/search?query=${query}`);
  }




  getArticulos() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get(`http://127.0.0.1:8000/api/auth/accesorios/indexPg${params}`).subscribe({
      next: (data: any) => {
        this.articulos = data.data;
        this.totalItems = data.total;
        this.totalPages = data.last_page;
        this.currentPage = data.current_page;
  
      },
      error: (error) => {
        console.error('There was an error!', error);
      }
    });
  }



   getStock() {

    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/accesorios/index').subscribe((data: any[]) => {
      this.stock = data;
     
    });


   }

  getTotalArticulos() {
    this.http.get('http://127.0.0.1:8000/api/auth/accesorios/getTotal').subscribe((data: any) => {
      this.totalArticulos = data.total;
    });
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
  
  goToPage(page: number) {
    this.page = page;
    this.getArticulos();
  }





  downloadAsExcel() {
    const ws: XLSX.WorkSheet = XLSX.utils.json_to_sheet(this.stock); 
    const wb: XLSX.WorkBook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'tablastock');
    XLSX.writeFile(wb, 'inventario.xlsx');
  }

  downloadAsPdf() {
    const doc = new jsPDF();
    autoTable(doc, { html: '#data-table' });  // sip
    doc.save('inventario.pdf');
  }
}

