import { Component, NgModule } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { FormsModule, NgModel } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { OnInit } from '@angular/core';
import Swal from 'sweetalert2'; // Importa SweetAlert2
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-llegada-accesorios',
  standalone: true,
  imports: [LayoutComponent, FormsModule, HttpClientModule, RouterLink],
  templateUrl: './llegada-accesorios.component.html',
  styleUrl: './llegada-accesorios.component.css'
})
export class LlegadaAccesoriosComponent implements OnInit {
  codigoBarras: string = '';
  articulo: string = '';
  cantidad: number = 0;
  marca: string = '';
  message: string = '';

  clearInputs() {
    this.marca = '';
    this.codigoBarras = '';
    this.cantidad = 0;
    this.marca = '';
    this.articulo = '';
    // Agrega aquí todas las demás variables que quieras limpiar
  }

  constructor(private http: HttpClient, private router:Router) { }
  

  ngOnInit(): void {
  }

  getAccesorioByBarCode() {
    this.http.get(`http://127.0.0.1:8000/api/auth/accesorios/getByBarCode/${this.codigoBarras}`).subscribe((data: any) => {
      this.articulo = data.articulo;
      this.marca = data.marca;
     
    }, error => {
      Swal.fire('Error', error,'error'); 
    });
  }


  updateQuantity() {
    this.http.put(`http://127.0.0.1:8000/api/auth/accesorios/updateQuantity/${this.codigoBarras}`, { cantidad: this.cantidad }).subscribe((data: any) => {
      Swal.fire('Éxito', data.message, 'success'); // Usa SweetAlert2 para mostrar el mensaje
    }, error => {
      Swal.fire('Error', error, 'error'); // Usa SweetAlert2 para mostrar el mensaje
    });
  }

  navigateTo(route:string){

    this.router.navigate([route]);

  }

}