import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import Swal from 'sweetalert2';
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';


@Component({
  selector: 'app-new-marca',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './new-marca.component.html',
  styleUrl: './new-marca.component.css'
})
export class NewMarcaComponent {

  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();

  marca = {

    nombre: ''

  };

  page: number = 1;
  pageSize: number = 20;
  totalItems: number = 0;
  totalPages: number = 0;
  currentPage: number = 0;


  selectedMarcaId: string | null = null;
  marcas: any[] = [];
  id: string = '';
  nombre: string = '';


  previousPage() {
    if (this.page > 1) {
      this.page--;
      this.getMarca();
    }
  }

  nextPage() {
    if (this.page < this.totalPages) {
      this.page++;
      this.getMarca();
    }
  }


 constructor(private http: HttpClient, private router: Router) { }


 ngOnInit() { 
  this.getMarca();

  this.searchSubject.pipe(
    debounceTime(300),
    distinctUntilChanged(),
    switchMap((query: string) => this.search(query))
  ).subscribe((results: any) => {
    this.marcas = results.data;
  })

}



onSearchChange(query: string) {
  this.searchSubject.next(query);
}

search(query: string): Observable<any[]> {
  return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/marca/search?query=${query}`);
}



getMarca() {
  const params = `?page=${this.page}&pageSize=${this.pageSize}`;
  this.http.get(`http://127.0.0.1:8000/api/auth/marca/index${params}`).subscribe({
    next: (data: any) => {
      this.marcas = data.data;
      this.totalItems = data.total;
      this.totalPages = data.last_page;
      this.currentPage = data.current_page;

    },
    error: (error) => {
      console.error('There was an error!', error);
    }
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
  this.getMarca();
}


obtenerNombre() {
  const url = `http://127.0.0.1:8000/api/auth/marca/get/${this.selectedMarcaId}`;
  this.http.get<any>(url).subscribe(
    data => {
      // Paso 2: Actualizar el modelo con los datos recibidos
      // Asumiendo que tienes propiedades en tu componente para cada uno de estos campos

      this.nombre = data.nombre;
    },
    error => {
      // Paso 3: Manejar errores
      console.error('Error al obtener el nombre:', error);
    }
  );
}

UpdateMarca() {
  const url = `http://127.0.0.1:8000/api/auth/marca/put/${this.selectedMarcaId}`;

  const body = {
    nombre: this.nombre,

  };

  this.http.put<any>(url, body).subscribe(
    data => {

      this.nombre = data.nombre;
      Swal.fire('Success', 'Marca actualizada correctamente', 'success');

      setTimeout(() => {
        location.reload();
      }, 1000);
  
    },
    error => {
      console.error('Error al actualizar', error);
      Swal.fire('Error', 'Hubo un error al actualizar la marca', 'error');
    }
  );
}


DeleteMarca() {
  const url = `http://127.0.0.1:8000/api/auth/marca/delete/${this.selectedMarcaId}`;



  this.http.delete<any>(url).subscribe(


    data => {
      Swal.fire('Success', 'Marca eliminada correctamente', 'success');
      setTimeout(() => {
        location.reload();
      }, 1000);
    },
    error => {
      console.error('Error al eliminar', error);
      Swal.fire('Error', 'Hubo un error al eliminar la marca', 'error');}


  );

}

CreateMarca() {

  this.http.post('http://127.0.0.1:8000/api/auth/marca/post', this.marca).subscribe( response => {

    console.log(response)

    Swal.fire({
      icon: 'success',
      title: 'Marca creada con éxito'
    });

    setTimeout(() => {
      location.reload();
    }, 1000);
  } , error => {

    let errorMessage = '';
    for (let key in error.error.message) {
      errorMessage += error.error.message[key] + ' ';
    }
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: errorMessage,
    });
  } )


}

openEditModal(id: string) {
  this.selectedMarcaId = id;
  this.obtenerNombre();



}
  navigateTo(route:string){

    this.router.navigate([route]);

  }


}
