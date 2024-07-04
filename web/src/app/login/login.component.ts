import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import Swal from 'sweetalert2';

export interface UserData {
  id: number;
  email: string;
  rol_id: number;
  name: string;
  num_empleado: number;

}

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [LayoutComponent, FormsModule, HttpClientModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent implements OnInit {

  public email: string = "";
  public password: string = "";

  public user_data: UserData = {
    email: '',
    id: 0,
    name: "",
    num_empleado: 0,
    rol_id: 0
  }

  constructor(private router: Router, private http: HttpClient) { }

  ngOnInit(): void {
    const storedUserData = localStorage.getItem('user_data');

    if(storedUserData){
      this.user_data = JSON.parse(storedUserData)

      if(this.user_data.email) {
        this.router.navigate(["/home"])
      }
    }
  }

  login() {
    if(this.email === "" || this.password === "") {
      Swal.fire("Error", "Debes de llenar todos los campos", "error")
      return
    }

    if(this.email === "") {
      Swal.fire("Error", "Favor de llenar el correo", "error")
      return
    }

    if(this.password === "") {
      Swal.fire("Error", "Favor de llenar la contraseña", "error")
      return
    }

    this.http.post("http://127.0.0.1:8000/api/auth/login/user", {
      email: this.email,
      password: this.password
    }).subscribe(
      (data: any) => {
        console.log(data)
        localStorage.setItem("user_data", JSON.stringify(data))

        this.router.navigate(["/home"])
      },
      (err: any) => {
        console.log(err)
        Swal.fire("Error", err.error.error || err.error.error.email[0] || err.error.error.password[0], "error");
      }
    )

  }

}
