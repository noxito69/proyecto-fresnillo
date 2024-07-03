import { Component, ElementRef, ViewChild, AfterViewInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import Swal from 'sweetalert2';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';




import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';

@Component({
  selector: 'app-new-etiqueta-pnmnt',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule,FormsModule,NgFor,RouterLink],
  templateUrl: './new-etiqueta-pnmnt.component.html',
  styleUrl: './new-etiqueta-pnmnt.component.css'
})
export class NewEtiquetaPNMNTComponent {


  numero_serie: string = '';
  usuario: string = '';
  host: string = '';
  modelo: string = '';

  mac: string = '';
  departamento: string = '';
  anexo: string = '';
  fecha_vigencia: string = '';
  fecha_actual: string = ''; 

  modelos: any[] = [];
  anexos: any[] = []; 
  
  departamentos: any[] = [];
  etiquetas: any[] = [];
  filteredEtiquetas: any[] = [];
 

  index: number = 0;

  nombre: string = '';
  centroCostos: string = '';
  numEmpleado: string = '';
  email: string = '';



  search: string = "";

  etiquetaImage: HTMLImageElement | null = null;
  imgWidth: number = 0;
  imgHeight: number = 0;

  
  

  @ViewChild('search-tag') searchInput!: ElementRef;

  constructor(private http:HttpClient, private router: Router,private route: ActivatedRoute) {

    const date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    this.fecha_vigencia = date.toISOString().split('T')[0];


  }

  buscarEmpleado() {
    this.http.get(`http://127.0.0.1:8000/api/auth/usuarios_penmont/getByEmployeeNumber/${this.numEmpleado}`).subscribe((data: any) => {
      this.usuario = data[0].nombre;
      this.centroCostos = data[0].centro_costo.nombre;
      this.departamento = data[0].departamento.nombre;
      this.email = data[0].email;

    });
  }

  ngAfterViewInit() {
    this.etiquetaImage = document.getElementById('etiquetaImage') as HTMLImageElement;
    if (this.etiquetaImage) {
      this.etiquetaImage.onload = () => {
        this.imgWidth = this.etiquetaImage!.naturalWidth * 0.264583;
        this.imgHeight = this.etiquetaImage!.naturalHeight * 0.264583;
      };
    }

    if (this.searchInput) {
      const searchElement = this.searchInput.nativeElement as HTMLInputElement;
      searchElement.addEventListener('keyup', () => {
        const value = searchElement.value.toLowerCase();
        console.log({value})
        this.filteredEtiquetas = this.etiquetas.filter(etiqueta =>
          etiqueta.id.toLowerCase().includes(value)
        );
      });
    }
  }


  exportToExcel() {
    const url = "http://127.0.0.1:8000/api/auth/etiquetas_empleados/index";
    this.http.get<any[]>(url).subscribe(
      (data: any[]) => {
        // Verificar si los datos se recibieron correctamente
        console.log(data);

        // Convertir los datos a un formato que XLSX pueda manejar
        const worksheet = XLSX.utils.json_to_sheet(data);

        // Crear un nuevo libro de trabajo y agregar la hoja de trabajo a él
        const workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, 'EtiquetasEmpleados');

        // Crear el archivo de Excel
        XLSX.writeFile(workbook, 'EtiquetasEmpleados.xlsx');
      },
      error => {
        console.error('Error al obtener las etiquetas:', error);
      }
    );
  }




  getLastTag(){
    this.http.get("http://127.0.0.1:8000/api/auth/etiquetas_empleados/last").subscribe(

      (data: any) => {
        this.index = data.data.id + 1;
      }
    );

  }

  getTags(){
  this.http.get("http://127.0.0.1:8000/api/auth/etiquetas_empleados/index").subscribe(
    (data:any) => {
      this.etiquetas = data;
      this.filteredEtiquetas = data; 
    }
  );
  }

  ngOnInit(): void {

    
    this.getLastTag();
    this.getTags();
    
    this.ObtenerDepartamento();
    this.ObtenerAnexo();
    this.ObtenerModelo();

  }





 
  ObtenerModelo(){

    this.http.get<any[]>("http://127.0.0.1:8000/api/auth/modelo/index").subscribe(

      data =>{

        this.modelos = data;

      

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





  
  

  CrearEtiqueta(){
    const url = "http://127.0.0.1:8000/api/auth/etiquetas_empleados/post";
    const body ={
      numero_serie: this.numero_serie,
      usuario: this.usuario,
      host: this.host,
      modelo: this.modelo,
      mac: this.mac,
      departamento: this.departamento,
      anexo: this.anexo,
      fecha_vigencia: this.fecha_vigencia,
      fecha_actual: this.fecha_actual
    }; 

    this.http.post(url,body).subscribe(
      response =>{
        this.generatePdf(); 
        Swal.fire("Exito", 'Etiqueta creada correctamente', 'success');
        setTimeout(() => {
          location.reload();
        }, 4000);
        },
        error => {
          const errorMessage = error.error && error.error.message
                    ? Object.values(error.error.message).join(' ')
                    : 'Error al crear la etiqueta';
          Swal.fire('Error', errorMessage, 'error');
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
