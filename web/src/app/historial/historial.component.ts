import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { CommonModule, NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Router } from '@angular/router';
import { MatPaginator, PageEvent } from '@angular/material/paginator';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';

@Component({
  selector: 'app-historial',
  standalone: true,
  imports: [LayoutComponent, CommonModule, NgFor, HttpClientModule, FormsModule],
  templateUrl: './historial.component.html',
  styleUrls: ['./historial.component.css']
})
export class HistorialComponent implements OnInit {

  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();

  historial: any[] = [];
  page: number = 1;
  pageSize: number = 5;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;

  constructor(private http: HttpClient, private router: Router) { }

  ngOnInit(): void {
    this.getHistorial();

    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.historial= results.data;
    })

  }


  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/historial/search?query=${query}`);
  }


  getHistorial() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get<any>('http://127.0.0.1:8000/api/auth/historial/index' + params).subscribe((response: any) => {
      this.historial = response.data;
      this.historial = response.data;
      this.totalItems = response.total;
      this.totalPages = response.last_page;
      this.currentPage = response.current_page;

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
