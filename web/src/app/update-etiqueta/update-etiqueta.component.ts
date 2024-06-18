import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import { Router, RouterLink } from '@angular/router';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-update-etiqueta',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,NgFor,RouterLink],
  templateUrl: './update-etiqueta.component.html',
  styleUrl: './update-etiqueta.component.css'
})
export class UpdateEtiquetaComponent {


  tipo_equipo: number = 0;
  marca: number = 0;
  modelo: string = '';
  numero_serie: string = '';
  usuario: string = '';
  empresa: number = 0;
  fecha_vigencia: string = '';
  fecha_actual: string = '';
  

  tipo_equipo_a: any[] = [];
  marcas: any[] = [];
  empresas: any[] = [];

  etiquetaImage: HTMLImageElement | null = null;
  imgWidth: number = 0;
  imgHeight: number = 0;

  constructor(private http: HttpClient, private router:Router) {
    const date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    this.fecha_vigencia = date.toISOString().split('T')[0];
  }

  

  ngOnInit() {
    this.ObtenerTipoEquipo();
    this.ObtenerMarca();
    this.ObtenerEmpresa();
  }

  ObtenerTipoEquipo() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/tipo_equipo/index').subscribe(
      data => {
        this.tipo_equipo_a = data;
      },
      error => {
        console.error('Error al obtener el equipo:', error);
      }
    );
  }

  ObtenerMarca() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/marca/index').subscribe(
      data => {
        this.marcas = data;
      },
      error => {
        console.error('Error al obtener la marca:', error);
      }
    );
  }

  ObtenerEmpresa() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/empresa_contratista/index').subscribe(
      data => {
        this.empresas = data;
      },
      error => {
        console.error('Error al obtener la empresa:', error);
      }
    );
  }

 
  ActualizarEtiqueta() {

    


    
  }

  


  navigateTo(route:string){

    this.router.navigate([route]);

  }


}
