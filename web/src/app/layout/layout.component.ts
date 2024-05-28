import { NgIf } from '@angular/common';
import { Component } from '@angular/core';

@Component({
  selector: 'app-layout',
  standalone: true,
  imports: [NgIf],
  templateUrl: './layout.component.html',
  styleUrl: './layout.component.css'
})
export class LayoutComponent {

  openMenu: string = '';

  toggleSubmenu(menu:string){

    this.openMenu = this.openMenu === menu ? '' : menu;

  }

}
