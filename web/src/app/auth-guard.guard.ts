import { CanActivateFn } from '@angular/router';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';


@Injectable({
  providedIn: 'root'
})
export class AuthGuard {
  constructor(private router: Router) {}

  canActivate: CanActivateFn = (route, state) => {
    const user = localStorage.getItem('user');
    if (user) {
      // Si hay un usuario en localStorage, permite el acceso a la ruta
      return true;
    } else {
      // Si no hay un usuario, redirige al login
      this.router.navigate(['/login']);
      return false;
    }
  };
}