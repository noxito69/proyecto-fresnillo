import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
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

  

  numero_etiqueta: number = 0;
  tipo_equipo: number = 0;
  marca: number = 0;
  modelo: string = '';
  numero_serie: string = '';
  usuario: string = '';
  empresa: number = 0;
  fecha_vigencia: string = '';
  fecha_actual: string = '';
  
  info: any[] = [];

  tipo_equipo_a: any[] = [];
  marcas: any[] = [];
  empresas: any[] = [];

  etiquetaImage: HTMLImageElement | null = null;
  imgWidth: number = 0;
  imgHeight: number = 0;

  constructor(private http: HttpClient, private router:Router, private route: ActivatedRoute) {
    const date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    this.fecha_vigencia = date.toISOString().split('T')[0];


    const date2 = new Date();
    date2.setFullYear(date2.getFullYear());
    this.fecha_actual = date2.toISOString().split('T')[0];
  }

  ngAfterViewInit() {
    this.etiquetaImage = document.getElementById('etiquetaImage') as HTMLImageElement;
    if (this.etiquetaImage) {
      this.etiquetaImage.onload = () => {
        this.imgWidth = this.etiquetaImage!.naturalWidth * 0.264583;
        this.imgHeight = this.etiquetaImage!.naturalHeight * 0.264583;
      };
    }
  }

  

  ngOnInit():void {

   
    this.ObtenerTipoEquipo();
    this.ObtenerMarca();
    this.ObtenerEmpresa();


    this.route.params.subscribe(params => {
      this.numero_etiqueta = +params['id']; // '+' convierte el valor a número
    });
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
        this.obtenerEtiquetaPorNumero();
      },
      error => {
        console.error('Error al obtener la empresa:', error);
      }
    );
  }

  obtenerEtiquetaPorNumero() {
    const url = `http://127.0.0.1:8000/api/auth/etiquetas_contratistas/getByNumber/${this.numero_etiqueta}`;
    this.http.get<any>(url).subscribe(
      data => {
        // Paso 2: Actualizar el modelo con los datos recibidos
        // Asumiendo que tienes propiedades en tu componente para cada uno de estos campos
        this.tipo_equipo = data.tipo_equipo;
        this.marca = data.marca;
        this.modelo = data.modelo;
        this.numero_serie = data.numero_serie;
        this.usuario = data.usuario;
        this.empresa = data.empresa;
        this.fecha_vigencia = data.fecha_vigencia;
      },
      error => {
        // Paso 3: Manejar errores
        console.error('Error al obtener la etiqueta:', error);
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
      const pdf = new jsPDF('landscape', 'mm', [this.imgWidth, this.imgHeight]);
      pdf.addImage(contentDataURL, 'PNG', 0, 0, this.imgWidth, this.imgHeight);

      const pdfBlob = pdf.output('blob');
      const pdfUrl = URL.createObjectURL(pdfBlob);
      const link = document.createElement('a');
      link.href = pdfUrl;
      link.download = 'etiqueta.pdf';
      link.click();
    }).catch(error => {
      console.error("Error generating PDF:", error);
      Swal.fire('Error', 'Ocurrió un error al generar el PDF.', 'error');
    });
  }


  actualizarEtiqueta() {
   
    const url = `http://127.0.0.1:8000/api/auth/etiquetas_contratistas/put/${this.numero_etiqueta}`;
    const datosEtiqueta = {
      numero_etiqueta: this.numero_etiqueta,
      tipo_equipo: this.tipo_equipo,
      marca: this.marca,
      modelo: this.modelo,
      numero_serie: this.numero_serie,
      usuario: this.usuario,
      empresa: this.empresa,
      fecha_vigencia: this.fecha_vigencia,
      fecha_actual: this.fecha_actual
    };
  
    this.http.put(url, datosEtiqueta).subscribe({
      next: (response) => {
        console.log('Etiqueta actualizada con éxito', response);
        this.generatePdf();
        Swal.fire('¡Actualizado!', 'La etiqueta ha sido actualizada con éxito.', 'success');

        setTimeout(() => {
          location.reload();
        }, 5000);

      },
      error: (error) => {
        console.error('Error al actualizar la etiqueta', error);
        let message = 'Error al actualizar la etiqueta.';
        if (error.error && typeof error.error === 'object') {
          message = Object.values(error.error).join(' ');
        }
        Swal.fire('Error', message, 'error');
      }
    });
  }


 
  
  


  navigateTo(route:string){

    this.router.navigate([route]);

  }


}
