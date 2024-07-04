import { NgIf } from '@angular/common';
import { Component } from '@angular/core';
import { Router, RouterLink } from '@angular/router';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [NgIf,RouterLink],
  templateUrl: './layout.component.html',
  styleUrl: './layout.component.css'
})
export class LayoutComponent {

  openMenu: string = '';

  public user_data: any;


  ngOnInit() {
    const jsonData = localStorage.getItem('user_data')

    if (!jsonData) {
      // Si no hay datos de usuario, redirige al login
      this.router.navigate(['/login']);
    } else {
      this.user_data = JSON.parse(jsonData);
    }
    
  }

  logout() {
    // Paso 1: Eliminar la información del usuario de localStorage
    localStorage.removeItem('user_data');
  
    // Paso 2: Redireccionar al usuario a la vista de login
    this.router.navigate(['/login']);
  }

  constructor(private router:Router) { }

  toggleSubmenu(menu:string){

    this.openMenu = this.openMenu === menu ? '' : menu;

  }

  navigateTo(route:string){

    this.router.navigate([route]);

  }



}
