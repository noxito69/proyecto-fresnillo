import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import { Router, RouterLink } from '@angular/router';
import Swal from 'sweetalert2'; 
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { Subject } from 'rxjs';

@Component({
  selector: 'app-prestamos',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,NgFor, RouterLink],
  templateUrl: './prestamos.component.html',
  styleUrl: './prestamos.component.css'
})
export class PrestamosComponent {


  nombre: string = '';
  centroCostos: string = '';
  departamento: string = '';
  numEmpleado: string = '';
  articulo: string = '';
  fecha_devolucion: string = '';
  
  articulosIds: any[] = [];
  marca: string = '';
  codigoBarras: string = '';
  cantidad: number = 0;
  x: string = '';


  isBarcodeHidden = true;
  isTableHidden = true;
  isDocHidden = true;

  articulos: any[] = [];

  

  constructor(private http: HttpClient, private router:Router) { }

  ResetInputs() {


    this.fecha_devolucion = '';
    this.numEmpleado = '';
    this.nombre = '';
    this.centroCostos = '';
    this.departamento = '';
    this.codigoBarras = '';
    this.cantidad = 0;
    this.marca = '';
    this.x = '';
    this.articulo = '';
    this.isBarcodeHidden = true;
    this.isTableHidden = true;
    this.isDocHidden = true;
    this.articulosIds = [];




  }

  ngOnInit() {

    


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
        this.isBarcodeHidden = false;
        this.x = data.nombre;
      },
      error: (error) => {
        let errorMessage = 'Ocurrió un error inesperado'; 
        if (error.status === 404) {
       
          errorMessage = error.error.message;
        } else if (error.status === 400) {
       
          const errors = error.error;
          errorMessage = errors[Object.keys(errors)[0]][0]; 
        }
        Swal.fire('Error', errorMessage, 'error');
        this.isBarcodeHidden = true;
      }
    });
  }


  getAccesorioByBarCode() {

    if (this.articulosIds.length >= 10) {
      Swal.fire('Error', 'No se pueden agregar más de 10 accesorios distintos', 'error');
      return;
    }

    if(this.codigoBarras == ''){
      Swal.fire('Error', 'Favor de escribir un codigo de barras', 'warning')
      return;
    }

    const isBarCodeAdded = this.articulosIds.some(item => item.codigoBarras === this.codigoBarras);

    console.log({isBarCodeAdded})

    if (isBarCodeAdded) {
      Swal.fire('Error', 'El código de barras ya ha sido agregado', 'error');
      }
      else {
      this.http.get(`http://127.0.0.1:8000/api/auth/accesorios/getByBarCode/${this.codigoBarras}`).subscribe((data: any) => {

        this.articulosIds.push({
          articulo_id: data.id,
          departamento: this.departamento,
          centro_costos: this.centroCostos,
          usuario: this.nombre,
          num_empleado: this.numEmpleado,
          cantidad: 0,
          codigoBarras: this.codigoBarras,
          articulo: data.articulo,
          marca: data.marca,
          stock: data.cantidad
        })

        this.isTableHidden = false;
        this.isDocHidden = false;
      }, error => {
        Swal.fire('Error', error.error.message, 'error'); // Muestra un mensaje de error
      });
    }
  }



incrementarCantidad(codigo: any) {
  // Incrementa la cantidad
  const art = this.articulosIds.find(code => code.codigoBarras === codigo)

  if (art.cantidad < art.stock) {
    art.cantidad++
  }
  else {
    Swal.fire('Error', 'No hay suficiente stock', 'error')
  }
}

decrementarCantidad(codigo: any, cantidad: any) {
  // Decrementa la cantidad si es mayor que 1
  if (cantidad > 1) {
    const art = this.articulosIds.find(code => code.codigoBarras === codigo)

    art.cantidad--
  }
}

generatePdf() {
  // Verificar si todos los campos requeridos están llenos
  if (!this.nombre || !this.centroCostos || !this.departamento || !this.numEmpleado || !this.fecha_devolucion || this.articulosIds.length === 0) {
    Swal.fire('Error', 'Todos los campos deben estar llenos antes de generar el PDF', 'warning');
    return;
  }

  const vale = document.getElementById('vale');
  if (!vale) {
    console.error("Element 'vale' not found");
    return;
  }

  html2canvas(vale).then(canvas => {
    const imgWidth = 208;
    const pageHeight = 295;
    const imgHeight = canvas.height * imgWidth / canvas.width;
    const contentDataURL = canvas.toDataURL('image/png');
    const pdf = new jsPDF('p', 'mm', 'a4'); // A4 size page of PDF
    const position = 0;
    pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight);
    // Generate the PDF and open it in a new tab
    const pdfBlob = pdf.output('blob');
    const pdfUrl = URL.createObjectURL(pdfBlob);

    this.saveToHistory()

    setTimeout(() => {
      window.open(pdfUrl);


      setTimeout(() => {

        location.reload();

      }, 5000);

    }, 4000);

   
  });
}


navigateTo(route:string){

  this.router.navigate([route]);

}

saveToHistory(){
  for(let history of this.articulosIds){
    this.http.post('http://127.0.0.1:8000/api/auth/historial_prestamo/post', {
      num_empleado: history.num_empleado,
      usuario: history.usuario,
      fecha_devolucion: this.fecha_devolucion,
      articulo_id: history.articulo_id,
      cantidad: history.cantidad,
      departamento: history.departamento,
      centro_costos: history.centro_costos
    }).subscribe(data => {
      // Actualiza la cantidad del accesorio
      this.http.put(`http://127.0.0.1:8000/api/auth/accesorios/updateQuantityMinus/${history.articulo_id}`, { cantidad: history.cantidad }).subscribe(data => {
        Swal.fire('Éxito', 'Generando PDF..', 'success');
     
      }, (error: any) => {
        Swal.fire('Error', error.error.message, 'error');
      })
    }, (error: any) => {
      Swal.fire('Error', error.error.message, 'error');
    })
  }
}

deleteArticulo(codigo: any){
  const index = this.articulosIds.findIndex(articulo => articulo.codigoBarras === codigo)

  if(index !== -1){
    this.articulosIds.splice(index, 1)
  }
}

}
