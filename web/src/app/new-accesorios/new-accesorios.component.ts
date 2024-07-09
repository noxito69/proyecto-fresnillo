import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import Swal from 'sweetalert2';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-new-accesorios',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,RouterLink],
  templateUrl: './new-accesorios.component.html',
  styleUrl: './new-accesorios.component.css'
})
export class NewAccesoriosComponent {

  
  cantidad: number = 0;
  articulo: string = '';
  marca: string = '';
  codigo_barras: string = '';

  constructor(private http:HttpClient, private router:Router) { }

  
  crearAccesorio() {
    const url = 'http://127.0.0.1:8000/api/auth/accesorios/post'; // Reemplaza con la URL de tu API
    const body = { cantidad: this.cantidad, articulo: this.articulo, marca: this.marca, codigo_barras: this.codigo_barras };

    this.http.post(url, body).subscribe(
      response => {
        Swal.fire('¡Éxito!', 'Accesorio creado con éxito.', 'success');
      },
      error => {
        if (error.error && error.error.message) {
          const errorMessage = Object.values(error.error.message).join(' ');
          Swal.fire('Error', errorMessage, 'error');
        } else {
          Swal.fire('Error', 'Ocurrió un error al crear el accesorio.', 'error');
        }
      }
    );
  }

  navigateTo(route:string){


    this.router.navigate([route]);
  
  } 
  

}
