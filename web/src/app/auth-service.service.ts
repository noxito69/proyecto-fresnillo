import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthServiceService {

  constructor() { }

  isLoggedIn(): boolean {


    const user = localStorage.getItem('user_data');
    return !!user;

  }

  hasRole(requiredRole:number): boolean {

    const user = JSON.parse(localStorage.getItem('user_data')||'{}');
    return user.rol_id === requiredRole;


  }

}
