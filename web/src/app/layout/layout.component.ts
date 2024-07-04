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

    this.user_data = JSON.parse(jsonData?? "")
  }

  constructor(private router:Router) { }

  toggleSubmenu(menu:string){

    this.openMenu = this.openMenu === menu ? '' : menu;

  }

  navigateTo(route:string){

    this.router.navigate([route]);

  }



}
