import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import Swal from 'sweetalert2'; // Importa SweetAlert2
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { CommonModule, NgFor } from '@angular/common';
import { Router, RouterLink } from '@angular/router';
import { catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';

@Component({
  selector: 'app-register',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule, FormsModule, NgFor,RouterLink],
  templateUrl: './register.component.html',
  styleUrl: './register.component.css'
})
export class RegisterComponent implements OnInit {

  nombre: string = '';
  numEmpleado: string = '';
  email: string = '';
  rol: number = 0;
  contrasena: string = '';
  confirmar_contrasena: string = '';



  roles: any[] = [];


  constructor(private http: HttpClient, private router: Router){  }



  
  ngOnInit(): void {
    this.http.get("http://127.0.0.1:8000/api/auth/roles/index").subscribe(
      (data: any) => {
        this.roles = data
      }
    )

    this.verificarUsuario();

  }


  

  verificarUsuario(): void {
    const userData = localStorage.getItem('user_data');
    if (userData) {
      const user = JSON.parse(userData);
      if (user.rol_id !== 1) { 
        this.router.navigate(['/home']); // Redirige a home si el rol no es 1
      }
    } else {
      this.router.navigate(['/login']); // Redirige a login si no está logueado
    }
  }






  

  buscarEmpleado() {
    if (!this.numEmpleado) {
      Swal.fire('Error', 'Favor de escribir un número de empleado', 'warning');
      return;
    }
    this.http.get(`http://127.0.0.1:8000/api/auth/usuarios_penmont/getByEmployeeNumber/${this.numEmpleado}`).subscribe({

      next: (data: any) => {
        this.nombre = data.nombre;
      },
      error: (error: any) => {
        let errorMessage = 'Ocurrió un error inesperado';
        if (error.status === 404) {
          errorMessage = error.error.message;
        } else if (error.status === 400) {
          const errors = error.error;
          errorMessage = errors[Object.keys(errors)[0]][0];
        }
        Swal.fire('Error', errorMessage, 'error');
      }
    });
  }

 

  register() {
    if(this.nombre === "" || this.contrasena === "" || this.confirmar_contrasena === "" || this.rol === 0 || this.email === ""){
      Swal.fire("Error", "Favor de llenar todos los campos", 'error');
      return;
    }
  
    if(this.confirmar_contrasena !== this.contrasena){
      Swal.fire("Error", "Las contraseñas no coinciden", 'error');
      return;
    }
  
    this.http.post("http://127.0.0.1:8000/api/auth/post", {
      num_empleado: this.numEmpleado,
      email: this.email,
      name: this.nombre,
      password: this.contrasena,
      rol_id: this.rol,
    }).pipe(
      catchError(error => {
        let message = "Ocurrió un error inesperado.";
        if (error.status === 422) {
          // Asegura que TypeScript entienda que 'errors' es un objeto con claves de tipo string y valores de tipo string[].
          const errors = error.error.errors as { [key: string]: string[] };
          message = Object.values(errors).map((msgArray) => msgArray.join('\n')).join('\n');
        }
        // Muestra el mensaje con SweetAlert2
        Swal.fire("Error", message, 'error');
        // Lanza el error para que no se procese como una respuesta exitosa
        return throwError(error);
      })
    ).subscribe(data => {
      Swal.fire("Éxito", "Usuario registrado correctamente", 'success');
    });
  }



  navigateTo(route:string){

    this.router.navigate([route]);

  }

}
