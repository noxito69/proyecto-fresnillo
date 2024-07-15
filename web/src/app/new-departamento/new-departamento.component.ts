import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule, NgModel } from '@angular/forms';
import Swal from 'sweetalert2';
import { Route, Router, RouterLink } from '@angular/router';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';

@Component({
  selector: 'app-new-departamento',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './new-departamento.component.html',
  styleUrl: './new-departamento.component.css'
})
export class NewDepartamentoComponent {



  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();


  departamento = {
    nombre: '',
    centro_costos: '',
    is_active: true

  };

  id: string = '';

  page: number = 1;
  pageSize: number = 20;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;

  selectedMarcaId: string | null = null;
  centrosCostos: any[] = [];
  departamentos: any[] = [];



  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getDepartamento();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getDepartamento();
    }
  }

  constructor(private http: HttpClient, private router:Router) { }
  ngOnInit() {
    this.obtenerCentrosCostos();

    this.getDepartamento();

    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.departamentos = results.data;
    })

  }

  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/departamentos/search?query=${query}`);
  }


  getDepartamento() {
    const params = `?page=${this.page}&pageSize=${this.pageSize}`;
    this.http.get(`http://127.0.0.1:8000/api/auth/departamentos/indexPg${params}`).subscribe({
      next: (data: any) => {

        this.departamentos = data.data;
        this.totalItems = data.total;
        this.totalPages = data.last_page;
        this.currentPage = data.current_page;


        // console.log({data: data.data})

      },
      error: (error) => {
        console.error('There was an error!', error);
      }
    });
  }


  obtenerNombre() {
    const url = `http://127.0.0.1:8000/api/auth/departamentos/get/${this.selectedMarcaId}`;
    this.http.get<any>(url).subscribe(
      data => {
        // Paso 2: Actualizar el modelo con los datos recibidos
        // Asumiendo que tienes propiedades en tu componente para cada uno de estos campos

        this.departamento.nombre = data.nombre;
        this.departamento.centro_costos = data.centro_costos;
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
    this.getDepartamento();
  }


  crearDepartamento() {
    this.http.post('http://127.0.0.1:8000/api/auth/departamentos/post', this.departamento)
        .subscribe(response => {
            Swal.fire({
                icon: 'success',
                title: 'Departamento creado con éxito'
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

UpdateDepartamento() {
  const url = `http://127.0.0.1:8000/api/auth/departamentos/put/${this.selectedMarcaId}`;

  const body = {
    nombre: this.departamento.nombre,
    centro_costos: this.departamento.centro_costos


  };

  this.http.put<any>(url, body).subscribe(
    data => {

      this.departamento.nombre = data.nombre;
      this.departamento.centro_costos = data.centro_costos;
      Swal.fire('Success', 'Departamento actualizado correctamente', 'success');

      setTimeout(() => {
        location.reload();
      }, 1000);

    },
    error => {
      console.error('Error al actualizar', error);
      Swal.fire('Error', 'Hubo un error al actualizar el departamento', 'error');
    }
  );
}


DeleteMarca() {
  const url = `http://127.0.0.1:8000/api/auth/departamentos/delete/${this.selectedMarcaId}`;



  this.http.delete<any>(url).subscribe(


    data => {
      Swal.fire('Success', 'departamento eliminado correctamente', 'success');
      setTimeout(() => {
        location.reload();
      }, 1000);
    },
    error => {
      console.error('Error al eliminar', error);
      Swal.fire('Error', 'Hubo un error al eliminar el departamento', 'error');}


  );

}


  toggleIsActive(departmentId: number, isActive: boolean) {
    // Lógica para enviar la actualización al backend
    // Por ejemplo, usando HttpClient
    this.http.put(`http://127.0.0.1:8000/api/auth/departamentos/delete/${departmentId}`, {})
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





  obtenerCentrosCostos() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/centro_costos/index')
      .subscribe(data => {
        this.centrosCostos = data;
      }, error => {
        console.error('Error al obtener centros de costos:', error);
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
