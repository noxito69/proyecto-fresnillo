import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { Chart, ChartDataset, ChartOptions, ChartType } from 'chart.js';
import { Color } from 'jspdf-autotable';



@Component({
  selector: 'app-grafica-contratistas',
  standalone: true,
  imports: [LayoutComponent,],
  templateUrl: './grafica-contratistas.component.html',
  styleUrl: './grafica-contratistas.component.css'
})
export class GraficaContratistasComponent {

  

  public lineChartData: ChartDataset[] = [
    { data: [65, 59, 80, 81, 56, 55, 40], label: 'Series A' }
  ];

  public lineChartLabels: string[] = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];

  public lineChartOptions: ChartOptions = {
    responsive: true,
  };

  public lineChartColors: any[] = [
    {
      borderColor: 'rgba(255,0,0,0.3)',
      backgroundColor: 'rgba(255,0,0,0.3)',
    }
  ];

  public lineChartLegend = true;
  public lineChartType: ChartType = 'line';

  constructor() { }



}


