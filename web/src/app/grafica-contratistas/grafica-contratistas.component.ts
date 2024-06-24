import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { Chart, ChartDataset, ChartOptions, ChartType } from 'chart.js';
import { Color } from 'jspdf-autotable';

import { GoogleChartInterface, Ng2GoogleChartsModule } from 'ng2-google-charts';
import { HttpClient, HttpClientModule } from '@angular/common/http'; 




@Component({
  selector: 'app-grafica-contratistas',
  standalone: true,
  imports: [LayoutComponent,Ng2GoogleChartsModule, HttpClientModule],
  templateUrl: './grafica-contratistas.component.html',
  styleUrl: './grafica-contratistas.component.css'
})
export class GraficaContratistasComponent {

  
  public pieChart: GoogleChartInterface = {
    chartType: 'PieChart',
    dataTable: [
      ['Topping', 'Slices'],
      ['Mushrooms', 3],
      ['Onions', 1],
      ['Olives', 1],
      ['Zucchini', 1],
      ['Pepperoni', 2]
    ],
    options: {
      title: 'How Much Pizza I Ate Last Night',
      width: 800, // Ancho del gráfico
      height: 600, // Altura del gráfico
      is3D: true, // Hacer que el gráfico sea 3D
      colors: ['#e0440e', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6'], // Colores de las rebanadas
    },
  };
 



}


