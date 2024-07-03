import { Component, ElementRef, ViewChild } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-update-etiqueta-pnmnt',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,NgFor,RouterLink],
  templateUrl: './update-etiqueta-pnmnt.component.html',
  styleUrl: './update-etiqueta-pnmnt.component.css'
})
export class UpdateEtiquetaPNMNTComponent {

  //variables de los inputs del formulario
  numero_serie: string = '';
  nombre: string = '';
  host: string = '';
  modelo: string = '';
  email: string = '';
  mac: string = '';
  departamento: string = '';
  anexo: string = '';
  fecha_vigencia: string = '';
  fecha_actual: string = ''; 
  numero_etiqueta: number = 0;
  ip: string = '';




  //arreglos donde se iteran los selects del formulario
  modelos: any[] = [];
  anexos: any[] = []; 
  departamentos: any[] = [];
  etiquetas: any[] = [];
  filteredEtiquetas: any[] = [];
 



  numEmpleado: string = '';




  search: string = "";

  etiquetaImage: HTMLImageElement | null = null;
  imgWidth: number = 0;
  imgHeight: number = 0;



  @ViewChild('search-tag') searchInput!: ElementRef;

  constructor(private http:HttpClient, private router: Router, private route: ActivatedRoute) {

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
  }


  
  ngOnInit(): void {


    this.ObtenerDepartamento();
    this.ObtenerAnexo();
    this.ObtenerModelo();

    this.route.params.subscribe(params => {
      this.numero_etiqueta = +params['id']; // '+' convierte el valor a número
    });

  }

  formatMacAddress() {
    if (!this.mac) return;
  
    // Elimina caracteres no hexadecimales y los dos puntos anteriores para empezar de cero
    let cleanInput = this.mac.replace(/[^0-9A-F]/gi, '');
  
    // Añade los dos puntos después de cada par de caracteres
    let formattedMac = cleanInput.match(/.{1,2}/g)?.join(':').slice(0, 17) || '';
  
    this.mac = formattedMac;
  }


  obtenerEtiquetaPorNumero() {
    const url = `http://127.0.0.1:8000/api/auth/etiquetas_empleados/getByNumeroEtiqueta/${this.numero_etiqueta}`;
    this.http.get<any>(url).subscribe(
      data => {
        // Paso 2: Actualizar el modelo con los datos recibidos
        // Asumiendo que tienes propiedades en tu componente para cada uno de estos campos
    
        this.departamento = data.data.departamento;
        this.anexo = data.data.anexo;
        this.mac = data.data.mac;
        this.email = data.data.correo;
        this.host = data.data.host;
        this.ip = data.data.ip;
        this.modelo = data.data.modelo;
        this.numero_serie = data.data.numero_serie;
        this.nombre = data.data.usuario;
        this.numero_serie = data.data.numero_serie;

        console.log(data);
        
      },
      error => {
        // Paso 3: Manejar errores
        console.error('Error al obtener la etiqueta:', error);
      }
    );
  }

  ObtenerModelo(){

    this.http.get<any[]>("http://127.0.0.1:8000/api/auth/modelo_empleado/index").subscribe(

      data =>{

        this.modelos = data;
        this.obtenerEtiquetaPorNumero();

      },
      error => {
        console.error('Error al obtener el modelo:', error);
      }


    );

  }



  
  ObtenerDepartamento(){
    this.http.get<any[]>("http://127.0.0.1:8000/api/auth/departamentos/index").subscribe(

      data => {
        this.departamentos = data;
      },
      error => {
        console.error('Error al obtener el departamento:', error);
      }
    );
  }

  ObtenerAnexo(){

    this.http.get<any[]>("http://127.0.0.1:8000/api/auth/anexos/index").subscribe(
      data =>{
        this.anexos = data;
      },
      error =>{
        console.error('Error al obtener el anexo:', error)
      }
    );
  }

  generatePdf() {
    const vale = document.getElementById('etiquetaEmpleado');
    if (!vale) {
      console.error("Element 'etiquetaEmpleado' not found");
      return;
    }
    html2canvas(vale, { scale: 1 }).then(canvas => {
      const contentDataURL = canvas.toDataURL('image/png');
      const pdf = new jsPDF('landscape', 'mm', [this.imgWidth, this.imgHeight]);
      pdf.addImage(contentDataURL, 'PNG', 0, 0, this.imgWidth, this.imgHeight);
  
      const pdfBlob = pdf.output('blob');
      const pdfUrl = URL.createObjectURL(pdfBlob);
  
      // Abrir el PDF en una nueva pestaña
      window.open(pdfUrl, '_blank');
    }).catch(error => {
      console.error("Error generating PDF:", error);
      Swal.fire('Error', 'Ocurrió un error al generar el PDF.', 'error');
    });
  }

  actualizarEtiqueta() {
    if (this.modelo === "") {
      Swal.fire("Error", 'Selecciona el tipo de equipo', 'error');
      return;
    }

    if (this.anexo === "") {
      Swal.fire("Error", 'Selecciona un Anexo', 'error');
      return;
    }

    if (this.departamento === "") {
      Swal.fire("Error", 'Selecciona un Departamento', 'error');
      return;
    }
    const url = `http://127.0.0.1:8000/api/auth/etiquetas_empleados/put/${this.numero_etiqueta}`;
    const datosEtiqueta = {
      numero_etiqueta: this.numero_etiqueta,
    
  
      modelo: this.modelo,
      mac: this.mac,
      correo: this.email,
      departamento: this.departamento,
      anexo: this.anexo,
      ip: this.ip,
      host: this.host,
      numero_serie: this.numero_serie,
      usuario: this.nombre,
      fecha_vigencia: this.fecha_vigencia,
   
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
  
  


  

