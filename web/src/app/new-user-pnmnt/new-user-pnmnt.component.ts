import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { FormsModule } from '@angular/forms';
import { NgFor } from '@angular/common';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Router, RouterLink } from '@angular/router';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-new-user-pnmnt',
  standalone: true,
  imports: [LayoutComponent, FormsModule, NgFor, HttpClientModule, RouterLink],
  templateUrl: './new-user-pnmnt.component.html',
  styleUrl: './new-user-pnmnt.component.css'
})
export class NewUserPnmntComponent {

  user = {
    nombre: '',
    num_empleado: '',
    email: '',
    departamento: '',
    centro_costos: '',

    
  };

  departamento: any[] = [];

  constructor(private http: HttpClient, private router: Router) { }

  CrearUsuario() {
    this.http.post('http://127.0.0.1:8000/api/auth/usuarios_penmont/post', this.user)
      .subscribe(response => {
        Swal.fire({
          icon: 'success',
          title: 'Usuario creado con éxito'
        });
      }, error => {
        let errorMessage = '';
        for (let key in error.error.message) {
          errorMessage += error.error.message[key] + ' ';
        }
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: errorMessage,
        });
      });
  }

  ngOnInit() {
    this.obtenerDepartamento();
  }

  obtenerDepartamento() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/departamentos/index')
      .subscribe(data => {
        this.departamento = data;
      }, error => {
        console.error('Error al obtener el departamento:', error);
      });
  }

  onDepartamentoChange(event: any) {
    const selectedDeptName = event.target.value;
    const selectedDept = this.departamento.find(dep => dep.nombre === selectedDeptName);
    if (selectedDept) {
      this.user.centro_costos = selectedDept.centro_costos;
    }
  }

  navigateTo(route: string) {
    this.router.navigate([route]);
  }
}
