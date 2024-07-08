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
import { debounceTime, distinctUntilChanged, Observable, Subject, switchMap } from 'rxjs';

@Component({
  selector: 'app-new-etiqueta-pnmnt',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule,FormsModule,NgFor,RouterLink],
  templateUrl: './new-etiqueta-pnmnt.component.html',
  styleUrl: './new-etiqueta-pnmnt.component.css'
})
export class NewEtiquetaPNMNTComponent {



  searchQuery: string = '';
  private searchSubject: Subject<string> = new Subject<string>();

  numero_serie: string = '';
  usuario: string = '';
  host: string = '';
  modelo: string = '';
  email: string = '';
  ip: string = '';
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
 

  numero_etiqueta: number = 0;

  nombre: string = '';
  centroCostos: string = '';
  numEmpleado: string = '';






  etiquetaImage: HTMLImageElement | null = null;
  imgWidth: number = 0;
  imgHeight: number = 0;

  
  ngOnInit(): void {

    
    this.getLastTag();
    this.getTags();

    this.ObtenerDepartamento();
    this.ObtenerAnexo();
    this.ObtenerModelo();

  }

  @ViewChild('search-tag') searchInput!: ElementRef;

  constructor(private http:HttpClient, private router: Router,private route: ActivatedRoute) {

    const date = new Date();
    date.setFullYear(date.getFullYear() + 1);
    this.fecha_vigencia = date.toISOString().split('T')[0];

    const date2 = new Date();
    date.setFullYear(date.getFullYear());
    this.fecha_actual = date2.toISOString().split('T')[0];

    this.searchSubject.pipe(
      debounceTime(300),
      distinctUntilChanged(),
      switchMap((query: string) => this.search(query))
    ).subscribe((results: any) => {
      this.etiquetas = results.data;
    })

  }

  
  onSearchChange(query: string) {
    this.searchSubject.next(query);
  }

  search(query: string): Observable<any[]> {
    return this.http.get<any[]>(`http://127.0.0.1:8000/api/auth/etiquetas_empleados/search?query=${query}`);
  }

  buscarEmpleado() {
    if (!this.numEmpleado) {
      Swal.fire('Error', 'Favor de escribir un número de empleado', 'warning');
      return;
    }
    this.http.get(`http://127.0.0.1:8000/api/auth/usuarios_penmont/getByEmployeeNumber/${this.numEmpleado}`).subscribe({




      next: (data: any) => {
        // Si se encuentra el empleado, continúa con la asignación de datos
        this.nombre = data.nombre;
        this.centroCostos = data.centro_costos;
        this.departamento = data.departamento;
        this.email = data.email;
    

     
      },
      error: (error) => {
        let errorMessage = 'Ocurrió un error inesperado'; // Mensaje por defecto
        if (error.status === 404) {
          // Error específico cuando el empleado no se encuentra
          errorMessage = error.error.message;
        } else if (error.status === 400) {
          // Error de validación, muestra el primer mensaje de error disponible
          const errors = error.error;
          errorMessage = errors[Object.keys(errors)[0]][0]; // Obtiene el primer mensaje de error de la respuesta
        }
        Swal.fire('Error', errorMessage, 'error');
   
      }
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
        this.numero_etiqueta = data.data.numero_etiqueta + 1;
      }
    );

  }

  getTags(){
  this.http.get("http://127.0.0.1:8000/api/auth/etiquetas_empleados/index").subscribe(
    (data:any) => {
      this.etiquetas = data.data;
      this.filteredEtiquetas = data.data; 
    }
  );
  }

 

  formatMacAddress() {
    if (!this.mac) return;
  
    // Elimina caracteres no hexadecimales y los dos puntos anteriores para empezar de cero
    let cleanInput = this.mac.replace(/[^0-9A-F]/gi, '');
  
    // Añade los dos puntos después de cada par de caracteres
    let formattedMac = cleanInput.match(/.{1,2}/g)?.join(':').slice(0, 17) || '';
  
    this.mac = formattedMac;
  }





 
  ObtenerModelo(){

    this.http.get<any[]>("http://127.0.0.1:8000/api/auth/modelo_empleado/index").subscribe(

      data =>{

        this.modelos = data;

      },
      error => {
        console.error('Error al obtener el modelo:', error);
      }

    );

  }

  ObtenerDepartamento(){
    this.http.get<any[]>("http://127.0.0.1:8000/api/auth/departamentos/indexAlfa").subscribe(

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

    const url = "http://127.0.0.1:8000/api/auth/etiquetas_empleados/post";
    const body ={
      numero_etiqueta: this.numero_etiqueta,
      numero_serie: this.numero_serie,
      usuario: this.nombre,
      host: this.host,
      modelo: this.modelo,
      mac: this.mac,
      correo: this.email,
      departamento: this.departamento,
      anexo: this.anexo,
      fecha_vigencia: this.fecha_vigencia,

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
          console.log("Correo a enviar:", this.email); // Agrega esto para depurar

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
  
      // Abrir el PDF en una nueva pestaña
      window.open(pdfUrl, '_blank');
    }).catch(error => {
      console.error("Error generating PDF:", error);
      Swal.fire('Error', 'Ocurrió un error al generar el PDF.', 'error');
    });
  }



  navigateTo(route: string) {
    this.router.navigate([route]);
  }


}
