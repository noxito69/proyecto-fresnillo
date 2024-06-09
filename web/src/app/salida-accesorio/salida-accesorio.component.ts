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


  generatePdf() {
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
      pdf.save('vale.pdf'); // Generated PDF
    });
  }

  navigateTo(route:string){

    this.router.navigate([route]);

  }
  

  getAccesorioByBarCode() {
    this.http.get(`http://127.0.0.1:8000/api/auth/accesorios/getByBarCode/${this.codigoBarras}`).subscribe((data: any) => {
      this.articulos.push({
        cantidad: data.cantidad,
        articulo: data.articulo,
        marca: data.marca

        

        
      });
      this.isTableHidden = false;
      this.isDocHidden = false;
    });
  }

}
