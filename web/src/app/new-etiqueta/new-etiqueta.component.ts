import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import Swal from 'sweetalert2';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-new-etiqueta',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,NgFor,RouterLink],
  templateUrl: './new-etiqueta.component.html',
  styleUrl: './new-etiqueta.component.css'
})
export class NewEtiquetaComponent{

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

  ngAfterViewInit() {
    this.etiquetaImage = document.getElementById('etiquetaImage') as HTMLImageElement;
    if (this.etiquetaImage) {
      this.etiquetaImage.onload = () => {
        this.imgWidth = this.etiquetaImage!.naturalWidth * 0.264583; // Convert to mm
        this.imgHeight = this.etiquetaImage!.naturalHeight * 0.264583; // Convert to mm
      }
    }
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

  CrearEtiqueta() {
    const url = 'http://127.0.0.1:8000/api/auth/etiquetas_contratistas/post';
    const body = { 
      tipo_equipo: this.tipo_equipo, 
      marca: this.marca, 
      modelo: this.modelo, 
      numero_serie: this.numero_serie, 
      usuario: this.usuario, 
      empresa: this.empresa, 
      fecha_vigencia: this.fecha_vigencia, 
      fecha_actual: this.fecha_actual 
    };

    this.http.post(url, body).subscribe(
      response => {
        this.generatePdf();
        Swal.fire('¡Éxito!', 'Etiqueta creada con éxito.', 'success');
        
        
      },
      error => {
        const errorMessage = error.error && error.error.message 
          ? Object.values(error.error.message).join(' ') 
          : 'Ocurrió un error al crear la etiqueta.';
        Swal.fire('Error', errorMessage, 'error');
      }
    );
  }

  generatePdf() {
    const vale = document.getElementById('etiqueta');
    if (!vale) {
      console.error("Element 'etiqueta' not found");
      return;
    }

  

    html2canvas(vale, { scale: 1 }).then(canvas => {
      const contentDataURL = canvas.toDataURL('image/png');
      const pdf = new jsPDF('landscape', 'mm', [this.imgWidth, this.imgHeight]); // Orientación en paisaje
      pdf.addImage(contentDataURL, 'PNG', 0, 0, this.imgWidth, this.imgHeight);

      const pdfBlob = pdf.output('blob');
      const pdfUrl = URL.createObjectURL(pdfBlob);
      window.open(pdfUrl);
    }).catch(error => {
      console.error("Error generating PDF:", error);
      Swal.fire('Error', 'Ocurrió un error al generar el PDF.', 'error');
    });
  }


  navigateTo(route:string){

    this.router.navigate([route]);

  }


}
