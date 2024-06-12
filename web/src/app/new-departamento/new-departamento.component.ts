import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule, NgModel } from '@angular/forms';
import Swal from 'sweetalert2';
import { Route, Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-new-departamento',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './new-departamento.component.html',
  styleUrl: './new-departamento.component.css'  
})
export class NewDepartamentoComponent {
  
  departamento = {
    nombre: '',
    centro_costos_id: null
  };

  centrosCostos: any[] = [];  
  
  constructor(private http: HttpClient, private router:Router) { }
  
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


  ngOnInit() {
    this.obtenerCentrosCostos();
  }



  obtenerCentrosCostos() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/centro_costos/index')
      .subscribe(data => {
        this.centrosCostos = data;
      }, error => {
        console.error('Error al obtener centros de costos:', error);
      });
  }

  
  navigateTo(route:string){


    this.router.navigate([route]);

  }





}
