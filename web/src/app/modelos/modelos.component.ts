import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-modelos',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './modelos.component.html',
  styleUrl: './modelos.component.css'
})
export class ModelosComponent {

  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();

  modelo = {
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
  modelos: any[] = [];


  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getModelo();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getModelo();
    }
  }

  constructor(private http: HttpClient, private router:Router) {}

  ngOnInit() {

    this.getModelo();


    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.modelos= results.data;
    })

  }

  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/modelo_empleado/search?query=${query}`);
  }


  getModelo() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get(`http://127.0.0.1:8000/api/auth/modelo_empleado/indexPg${params}`).subscribe({
      next: (data: any) => {
        this.modelos = data.data;
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
    const url = `http://127.0.0.1:8000/api/auth/modelo_empleado/get/${this.selectedMarcaId}`;
    this.http.get<any>(url).subscribe(
      data => {
    
        this.modelo.nombre = data.nombre;

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
    this.getModelo();
  }




  crearModelo() {
    this.http.post('http://127.0.0.1:8000/api/auth/modelo_empleado/post', this.modelo)
        .subscribe(response => {
            Swal.fire({
                icon: 'success',
                title: 'Modelo creado con éxito'
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



toggleIsActive(departmentId: number, isActive: boolean) {
  this.http.put(`http://127.0.0.1:8000/api/auth/modelo_empleado/delete/${departmentId}`, {})
    .subscribe({
      next: (response) => {
        
        console.log('Estado actualizado', response);
      },
      error: (error) => {
        
        console.error('Error al actualizar estado', error);
      }
    });
}



UpdateModelo() {
  const url = `http://127.0.0.1:8000/api/auth/modelo_empleado/put/${this.selectedMarcaId}`;

  const body = {
    nombre: this.modelo.nombre,
   
  };

  this.http.put<any>(url, body).subscribe(
    data => {

      this.modelo.nombre = data.nombre;

      Swal.fire('Success', 'modelo actualizado correctamente', 'success');

      setTimeout(() => {
        location.reload();
      }, 1000);
  
    },
    error => {
      console.error('Error al actualizar', error);
      Swal.fire('Error', 'Hubo un error al actualizar el modelo', 'error');
    }
  );
}




openEditModal(id: string) {
  this.selectedMarcaId = id;
  this.obtenerNombre();

}


navigateTo(route:string){


  this.router.navigate([route]);

} 




}
