import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import Swal from 'sweetalert2'; // Importa SweetAlert2
import { NgFor } from '@angular/common';
import html2canvas from 'html2canvas';
import jsPDF from 'jspdf';
import { Router, RouterLink, RouterOutlet } from '@angular/router';
@Component({
  selector: 'app-salida-accesorio',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,FormsModule,NgFor, RouterLink],
  templateUrl: './salida-accesorio.component.html',
  styleUrl: './salida-accesorio.component.css'
})
export class SalidaAccesorioComponent {

  nombre: string = '';
  centroCostos: string = '';
  departamento: string = '';
  numEmpleado: string = '';

  articulo: string = '';
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




  buscarEmpleado() {
    this.http.get(`http://127.0.0.1:8000/api/auth/usuarios_penmont/getByEmployeeNumber/${this.numEmpleado}`).subscribe((data: any) => {
      this.nombre = data[0].nombre;
      this.centroCostos = data[0].centro_costo.nombre;
      this.departamento = data[0].departamento.nombre;
      this.isBarcodeHidden = false;
      this.x = data[0].nombre;
    });
  }

  getAccesorioByBarCode() {

    if(this.codigoBarras == ''){
      Swal.fire('Error', 'Favor de escribir un codigo de barras', 'warning')
      return;
    }

    const isBarCodeAdded = this.articulosIds.some(item => item.codigoBarras === this.codigoBarras);

    console.log({isBarCodeAdded})

    if (isBarCodeAdded) {
      Swal.fire('Error', 'El código de barras ya ha sido agregado', 'error'); // Muestra un mensaje de error
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
        })

        this.isTableHidden = false;
        this.isDocHidden = false;
      }, error => {
        Swal.fire('Error', error.error.message, 'error');
      });
    }
  }

  incrementarCantidad(codigo: any) {
    // Incrementa la cantidad
    const art = this.articulosIds.find(code => code.codigoBarras === codigo)

    art.cantidad++
  }

  decrementarCantidad(codigo: any, cantidad: any) {
    // Decrementa la cantidad si es mayor que 1
    if (cantidad > 0) {
      const art = this.articulosIds.find(code => code.codigoBarras === codigo)

      art.cantidad--
    }
  }

  generatePdf() {
    const vale = document.getElementById('vale');
    if (!vale) {
      console.error("Element 'vale' not found");
      return;
    }

    this.saveToHistory()


    html2canvas(vale).then(canvas => {
      const imgWidth = 208;
      const pageHeight = 295;
      const imgHeight = canvas.height * imgWidth / canvas.width;

      const contentDataURL = canvas.toDataURL('image/png');
      const pdf = new jsPDF('p', 'mm', 'a4'); // A4 size page of PDF
      const position = 0;
      pdf.addImage(contentDataURL, 'PNG', 0, position, imgWidth, imgHeight);
      pdf.save('vale.pdf'); // Generated PDF
    });
  }

  navigateTo(route:string){

    this.router.navigate([route]);

  }

  saveToHistory(){
    for(let history of this.articulosIds){
      this.http.post('http://127.0.0.1:8000/api/auth/historial/post', {
        num_empleado: history.num_empleado,
        usuario: history.usuario,
        articulo_id: history.articulo_id,
        cantidad: history.cantidad,
        departamento: history.departamento,
        centro_costos: history.centro_costos
      }).subscribe(data => {
        // Actualiza la cantidad del accesorio
        this.http.put(`http://127.0.0.1:8000/api/auth/accesorios/updateQuantityMinus/${history.articulo_id}`, { cantidad: history.cantidad }).subscribe(data => {
        }, (error: any) => {
          Swal.fire('Error', error.error.message, 'error');
        })
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
