import { Component, ElementRef, ViewChild, AfterViewInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import Swal from 'sweetalert2';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { Router, RouterLink } from '@angular/router';


import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';

@Component({
  selector: 'app-new-etiqueta',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule, FormsModule, NgFor, RouterLink],
  templateUrl: './new-etiqueta.component.html',
  styleUrls: ['./new-etiqueta.component.css']
})
export class NewEtiquetaComponent implements AfterViewInit {

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
  etiquetas: any[] = [];
  filteredEtiquetas: any[] = [];
  numero_etiqueta: number = 0;

  search: string = "";

  etiquetaImage: HTMLImageElement | null = null;
  imgWidth: number = 0;
  imgHeight: number = 0;

  @ViewChild('search-tag') searchInput!: ElementRef;

  constructor(private http: HttpClient, private router: Router) {
    const date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    this.fecha_vigencia = date.toISOString().split('T')[0];


    const date2 = new Date();
    date.setFullYear(date.getFullYear());
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

    /*if (this.searchInput) {
      const searchElement = this.searchInput.nativeElement as HTMLInputElement;
      searchElement.addEventListener('keyup', () => {
        const value = searchElement.value.toLowerCase();
        console.log({value})
        this.filteredEtiquetas = this.etiquetas.filter(etiqueta =>
          etiqueta.id.toLowerCase().includes(value)
        );
      });
    }*/
  }

  exportToExcel() {
    const url = "http://127.0.0.1:8000/api/auth/etiquetas_contratistas/index";
    this.http.get<any[]>(url).subscribe(
      (data: any[]) => {
        // Verificar si los datos se recibieron correctamente
        console.log(data);

        // Convertir los datos a un formato que XLSX pueda manejar
        const worksheet = XLSX.utils.json_to_sheet(data);

        // Crear un nuevo libro de trabajo y agregar la hoja de trabajo a él
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'EtiquetasContratistas');

        // Crear el archivo de Excel
        XLSX.writeFile(workbook, 'EtiquetasContratistas.xlsx');
      },
      error => {
        console.error('Error al obtener las etiquetas:', error);
      }
    );
  }

  getLastTag() {
    this.http.get("http://127.0.0.1:8000/api/auth/etiquetas_contratistas/last").subscribe(
      (data: any) => {
        this.numero_etiqueta = data.data.numero_etiqueta + 1;
      }
    );
  }

  

  getTags() {
    this.http.get("http://127.0.0.1:8000/api/auth/etiquetas_contratistas/index").subscribe(
      (data: any) => {
        this.etiquetas = data;
        this.filteredEtiquetas = data; // Initialize filteredEtiquetas
      }
    );
  }

  ngOnInit() {
    this.getLastTag();
    this.ObtenerTipoEquipo();
    this.ObtenerMarca();
    this.ObtenerEmpresa();
    this.getTags();
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
    if (this.tipo_equipo === 0) {
      Swal.fire("Error", 'Verifica el tipo de equipo', 'error');
      return;
    }

    if (this.marca === 0) {
      Swal.fire("Error", 'Verifica la marca', 'error');
      return;
    }

    if (this.modelo === '') {
      Swal.fire("Error", 'Verifica el modelo', 'error');
      return;
    }

    if (this.numero_serie === '') {
      Swal.fire("Error", 'Verifica el número de serie', 'error');
      return;
    }

    if(this.empresa === 0) {

      Swal.fire("Error", 'Verifica la empresa', 'error');
      return;

    }
    

    const url = 'http://127.0.0.1:8000/api/auth/etiquetas_contratistas/post';
    const body = {
      numero_etiqueta: this.numero_etiqueta,
      tipo_equipo: this.tipo_equipo,
      marca: this.marca,
      modelo: this.modelo,
      numero_serie: this.numero_serie,
      usuario: this.usuario,
      empresa: this.empresa,
      fecha_vigencia: this.fecha_vigencia,
     
    };

    this.http.post(url, body).subscribe(
      response => { 
        this.generatePdf();
        Swal.fire('¡Éxito!', 'Etiqueta creada con éxito.', 'success');

        setTimeout(() => {
          location.reload();
        }, 3000);

      },
      error => {
        let errorMessage = '';
        for (let key in error.error.message) {
            errorMessage += error.error.message[key] + ' ';
        }
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: errorMessage,
        });
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
      window.open(pdfUrl);
    }).catch(error => {
      console.error("Error generating PDF:", error);
      Swal.fire('Error', 'Ocurrió un error al generar el PDF.', 'error');
    });
  }

  navigateTo(route: string) {
    this.router.navigate([route]);
  }
}
