import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-centro-costos',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './centro-costos.component.html',
  styleUrl: './centro-costos.component.css'
})
export class CentroCostosComponent {


  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();

  centro = {
    nombre: '',
    is_active: true
    	
  };

  id: string = '';
  page: number = 1;
  pageSize: number = 20;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;
  selectedMarcaId: string | null = null;
  centros: any[] = [];


  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getCentros();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getCentros();
    }
  }


  constructor(private http: HttpClient, private router:Router) {}

  ngOnInit() {

    this.getCentros();


    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.centros= results.data;
    })

  }

  
  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/centro_costos/search?query=${query}`);
  }



  getCentros() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get(`http://127.0.0.1:8000/api/auth/centro_costos/indexPg${params}`).subscribe({
      next: (data: any) => {
        this.centros = data.data;
        this.totalItems = data.total;
        this.totalPages = data.last_page;
        this.currentPage = data.current_page;
      
  
      },
      error: (error) => {
        console.error('There was an error!', error);
      }
    });
  }


  obtenerNombre() {
    const url = `http://127.0.0.1:8000/api/auth/centro_costos/get/${this.selectedMarcaId}`;
    this.http.get<any>(url).subscribe(
      data => {
    
        this.centro.nombre = data.nombre;

      },
      error => {
        // Paso 3: Manejar errores
        console.error('Error al obtener el nombre:', error);
      }
    );
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
    this.getCentros();
  }

  crearCentro() {
    this.http.post('http://127.0.0.1:8000/api/auth/centro_costos/post', this.centro)
        .subscribe(response => {
            Swal.fire({
                icon: 'success',
                title: 'Empresa creada con éxito'
            });
        }, error => {
            let errorMessage = '';
            for (let key in error.error.message) {
                errorMessage += error.error.message[key] + ' ';
            }
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessage,
            });
        });
}




UpdateCentro() {
  const url = `http://127.0.0.1:8000/api/auth/centro_costos/put/${this.selectedMarcaId}`;

  const body = {
    nombre: this.centro.nombre,
   
  };

  this.http.put<any>(url, body).subscribe(
    data => {

      this.centro.nombre = data.nombre;

      Swal.fire('Success', 'centro actualizada correctamente', 'success');

      setTimeout(() => {
        location.reload();
      }, 1000);
  
    },
    error => {
      console.error('Error al actualizar', error);
      Swal.fire('Error', 'Hubo un error al actualizar la centro', 'error');
    }
  );
}




toggleIsActive(departmentId: number, isActive: boolean) {
   this.http.put(`http://127.0.0.1:8000/api/auth/centro_costos/delete/${departmentId}`, {})
    .subscribe({
      next: (response) => {
        // Manejar respuesta exitosa
        console.log('Estado actualizado', response);
      },
      error: (error) => {
        // Manejar error
        console.error('Error al actualizar estado', error);
      }
    });
}



openEditModal(id: string) {
  this.selectedMarcaId = id;
  this.obtenerNombre();

}


navigateTo(route:string){


  this.router.navigate([route]);

} 


}
