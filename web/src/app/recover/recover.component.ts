import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import Swal from 'sweetalert2';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-recover',
  standalone: true,
  imports: [LayoutComponent, HttpClientModule, FormsModule],
  templateUrl: './recover.component.html',
  styleUrl: './recover.component.css'
})
export class RecoverComponent {

  public email: string = "";
  public password: string = "";
  public confirm_password: string = "";

  constructor(private http: HttpClient, private router:Router ) { }

  updatePassword() {
    if(this.password !== this.confirm_password){
      Swal.fire("Error", "Las contraseñas no coinciden", "error");
      return
    }

    this.http.put("http://127.0.0.1:8000/api/auth/user/editPassword", {
      email: this.email,
      password: this.password,
      confirm_password: this.confirm_password
    }).subscribe(
      (data: any) => {
        Swal.fire("Éxito", "La contraseña se ha actualizado con éxito", "success");
      },
      (error: any) => {
        console.log(error.error.error.email[0])
        Swal.fire("Error", error.error.message || error.error.error.confirm_password[0] || error.error.error.email[0] || error.error.error.password[0], "error")
      }
    )

  }


  navigateTo(route:string){

    this.router.navigate([route]);

  }

}
