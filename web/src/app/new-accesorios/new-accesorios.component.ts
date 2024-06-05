import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-new-accesorios',
  standalone: true,
  imports: [LayoutComponent,HttpClientModule],
  templateUrl: './new-accesorios.component.html',
  styleUrl: './new-accesorios.component.css'
})
export class NewAccesoriosComponent {

  

}
