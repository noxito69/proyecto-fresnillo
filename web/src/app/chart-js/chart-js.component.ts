import { Component } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { CommonModule, NgFor } from '@angular/common';
import { RouterOutlet } from '@angular/router';
import { CanvasJSAngularChartsModule } from '@canvasjs/angular-charts';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-chart-js',
  standalone: true,
  imports: [LayoutComponent, CommonModule,RouterOutlet,CanvasJSAngularChartsModule, FormsModule,NgFor,HttpClientModule],
  templateUrl: './chart-js.component.html',
  styleUrl: './chart-js.component.css'
})
export class ChartJsComponent {

  constructor(private http:HttpClient) { }
  
  equipos: any[] = [];


  ngOnInit() {

    this.ObtenerEquipos();

  }

  ObtenerEquipos() {
    this.http.get<any[]>('http://127.0.0.1:8000/api/auth/etiquetas_contratistas/equipos_general')
      .subscribe(
        data => {
          const dataPoints = data.map(item => ({
            y: item.total,
            name: item.empresa
          }));
  
          // Crear un nuevo objeto para chartOptions para asegurar la detección de cambios
          this.chartOptions = {
            ...this.chartOptions, // Copia las propiedades existentes
            data: [{ // Asegúrate de mantener la estructura esperada por CanvasJS
            
              type: "doughnut",
              showInLegend: true,
              innerRadius: "65%",
              yValueFormatString: "#,###",
              dataPoints: dataPoints

            }]
          };
  
          // Angular debería detectar este cambio automáticamente y actualizar la gráfica.
        },
        error => {
          console.error('Error al obtener los equipos:', error);
        }
      );
  }

  x = 0;
  y = 900;
  legends: any[] = [];

  


  




 

  chartOptions = {
    
    
    height: this.y,
    width: this.x,
    animationEnabled: true,
    legend: {
      horizontalAlign: "left",
      verticalAlign: "bottom",
      reversed: true,
      fontSize: 20
      
    
    },
    theme: "dark2",
    colorSet: "customColorSet",
    title:{
      text: "Equipos Empresas"
    },
    data: [{
      showInLegend: true,
      type: "pie",
      
      innerRadius: "65%",
      yValueFormatString: "#,##'",
      dataPoints: [
      { y: 33, name: "Open Dump" },
    
      ]
    }]
    }


}
