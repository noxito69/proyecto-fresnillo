import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-anexos',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './anexos.component.html',
  styleUrl: './anexos.component.css'
})
export class AnexosComponent {

  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();

  anexo = {
    nombre: '',
    fecha_caducidad: ''
    	
  };

  id: string = '';
  page: number = 1;
  pageSize: number = 20;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;
  selectedMarcaId: string | null = null;
  anexos: any[] = []; 


  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getAnexos();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getAnexos();
    }
  }

  constructor(private http: HttpClient, private router:Router) {}


  ngOnInit() {

    this.getAnexos();


    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.anexos= results.data;
    })

  }

  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/anexos/search?query=${query}`);
  }

  getAnexos() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get(`http://127.0.0.1:8000/api/auth/anexos/indexPg${params}`).subscribe({
      next: (data: any) => {
        this.anexos = data.data;
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
    const url = `http://127.0.0.1:8000/api/auth/anexos/get/${this.selectedMarcaId}`;
    this.http.get<any>(url).subscribe(
      data => {
    
        this.anexo.nombre = data.nombre;
        this.anexo.fecha_caducidad = data.fecha_caducidad;

      },
      error => {
   
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
    this.getAnexos();
  }


  crearAnexo() {
    this.http.post('http://127.0.0.1:8000/api/auth/anexos/post', this.anexo)
        .subscribe(response => {
            Swal.fire({
                icon: 'success',
                title: 'Anexo creado con éxito'
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


UpdateAnexo() {
  const url = `http://127.0.0.1:8000/api/auth/anexos/put/${this.selectedMarcaId}`;

  const body = {
    nombre: this.anexo.nombre,
    fecha_caducidad: this.anexo.fecha_caducidad,
   
  };

  this.http.put<any>(url, body).subscribe(
    data => {

      this.anexo.nombre = data.nombre;
      this.anexo.fecha_caducidad = data.fecha_caducidad;

      Swal.fire('Success', 'anexo actualizado correctamente', 'success');

      setTimeout(() => {
        location.reload();
      }, 1000);
  
    },
    error => {
      console.error('Error al actualizar', error);
      Swal.fire('Error', 'Hubo un error al actualizar el anexo', 'error');
    }
  );
}


DeleteAnexo() {
  const url = `http://127.0.0.1:8000/api/auth/anexos/delete/${this.selectedMarcaId}`;

  this.http.delete<any>(url).subscribe(

    data => {
      Swal.fire('Success', 'Anexo eliminado con exito', 'success');
      setTimeout(() => {
        location.reload();
      }, 1000);
    },
    error => {
      console.error('Error al eliminar', error);
      Swal.fire('Error', 'Hubo un error al eliminar el Anexo', 'error');}


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
