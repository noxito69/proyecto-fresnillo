import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import Swal from 'sweetalert2';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';

@Component({
  selector: 'app-new-etiqueta',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,NgFor],
  templateUrl: './new-etiqueta.component.html',
  styleUrl: './new-etiqueta.component.css'
})
export class NewEtiquetaComponent{

  tipo_equipo_id: number = 0;
  marca_id: number = 0;
  modelo: string = '';
  numero_serie: string = '';
  usuario: string = '';
  empresa_id: number = 0;
  fecha_vigencia: string = '';
  fecha_actual: string = '';

  tipo_equipo: any[] = [];
  marcas: any[] = [];
  empresas: any[] = [];



  



  constructor (private http:HttpClient) { 

    const date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    this.fecha_vigencia = date.toISOString().split('T')[0];

  }

  CrearEtiqueta() {

    const url ='http://127.0.0.1:8000/api/auth/etiquetas_contratistas/post';
    const body = { tipo_equipo_id:this.tipo_equipo_id, marca_id:this.marca_id ,modelo:this.modelo ,numero_serie: this.numero_serie, usuario: this.usuario, empresa_id: this.empresa_id, fecha_vigencia: this.fecha_vigencia, fecha_actual:this.fecha_actual };

    this.http.post(url, body).subscribe(

      response => {
        Swal.fire('¡Éxito!', 'Etiqueta creada con éxito.', 'success');
      },
      error => {
        if (error.error && error.error.message) {
          const errorMessage = Object.values(error.error.message).join(' ');
          console.error(errorMessage);
          Swal.fire('Error', errorMessage, 'error');
          
        } else {
          Swal.fire('Error', 'Ocurrió un error al crear la etiqueta.', 'error');
        }
      }


      
    );


  }


  ngOnInit() {

    this.ObtenerTipoEquipo();
    this.ObtenerMarca();
    this.ObtenerEmpresa();
  }
  

  
  ObtenerTipoEquipo() {

    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/tipo_equipo/index')
    .subscribe(data=>{
      this.tipo_equipo = data;  
    }, error => {
      console.error('Error al obtener el equipo:', error);

    });

  }

  ObtenerMarca() {

    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/marca/index')
    .subscribe(data=>{
      this.marcas = data;  
    }, error => {
      console.error('Error al obtener la marca:', error);

    });


  }

  ObtenerEmpresa(){

    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/empresa_contratista/index')
    .subscribe(data=>{
      this.empresas = data;  
    }, error => {
      console.error('Error al obtener la marca:', error);

    });


  }

}
