import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import Swal from 'sweetalert2';


@Component({
  selector: 'app-new-marca',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule,NgFor,FormsModule,RouterLink],
  templateUrl: './new-marca.component.html',
  styleUrl: './new-marca.component.css'
})
export class NewMarcaComponent {


  marca = {

    nombre: ''    

  };


  selectedMarcaId: string | null = null;
  marcas: any[] = [];
  id: string = '';
  nombre: string = '';
  




 constructor(private http: HttpClient, private router: Router) { }


 ngOnInit() { // Corrige el nombre aquí
  this.getMarca();
}


getMarca() {
  this.http.get('http://127.0.0.1:8000/api/auth/marca/index').subscribe({
    next: (data: any) => {
      this.marcas = data;
      
    },
    error: (error) => {
      console.error('There was an error!', error);
    }
  });
}


obtenerNombre() {
  const url = `http://127.0.0.1:8000/api/auth/marca/get/${this.selectedMarcaId}`;
  this.http.get<any>(url).subscribe(
    data => {
      // Paso 2: Actualizar el modelo con los datos recibidos
      // Asumiendo que tienes propiedades en tu componente para cada uno de estos campos
  
      this.nombre = data.nombre;
    },
    error => {
      // Paso 3: Manejar errores
      console.error('Error al obtener el nombre:', error);
    }
  );
}

UpdateMarca() {
  const url = `http://127.0.0.1:8000/api/auth/marca/put/${this.selectedMarcaId}`;
  // Asegúrate de que el objeto que envías coincide con lo que tu backend espera
  const body = {
    nombre: this.nombre,
    // Incluye aquí cualquier otro campo que necesites actualizar
  };

  this.http.put<any>(url, body).subscribe(
    data => {
      // Actualiza el modelo con los datos recibidos, si es necesario
      this.nombre = data.nombre;
      Swal.fire('Success', 'Marca actualizada correctamente', 'success');
      
      setTimeout(() => {
        location.reload();
      }, 1000);
      // Aquí podrías querer recargar los datos de la tabla o realizar alguna otra acción para reflejar la actualización
    },
    error => {
      console.error('Error al actualizar', error);
      Swal.fire('Error', 'Hubo un error al actualizar la marca', 'error');
    }
  );
}





CreateMarca() {

  this.http.post('http://127.0.0.1:8000/api/auth/marca/post', this.marca)
  .subscribe( response => {

    Swal.fire({
      icon: 'success',
      title: 'Marca creada con éxito'
    });

    setTimeout(() => {
      location.reload();
    }, 1000); 
  } , error => {

    let errorMessage = '';
    for (let key in error.error.message) {
      errorMessage += error.error.message[key] + ' ';
    }
    Swal.fire({
      icon: 'error',
      title: 'Oops...',
      text: errorMessage,
    });
  } )


}

openEditModal(id: string) {
  this.selectedMarcaId = id;
  this.obtenerNombre();
 
 
  
}
  navigateTo(route:string){

    this.router.navigate([route]);

  }


}
