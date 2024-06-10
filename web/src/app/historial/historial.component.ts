
import { Component, OnInit } from '@angular/core';
import { LayoutComponent } from '../layout/layout.component';
import { CommonModule, NgFor } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { HttpClient, HttpClientModule } from '@angular/common/http';
import { Router } from '@angular/router';

@Component({
  selector: 'app-historial',
  standalone: true,
  imports: [LayoutComponent, CommonModule, NgFor, HttpClientModule],
  templateUrl: './historial.component.html',
  styleUrl: './historial.component.css'
})
export class HistorialComponent implements OnInit {

  historial: any[] = [];

  constructor(private http: HttpClient, private router:Router) { }

  ngOnInit(): void {

    this.getHistorial()

  }

  getHistorial() {
    this.http.get('http://127.0.0.1:8000/api/auth/historial/index').subscribe(
      (data: any) => {
        console.log(data)
        this.historial = data
      }
    )
  }

  addLeadingZeros(number: number, length: number) {
    let numStr = String(number);

    let zerosToAdd = Math.max(length - numStr.length, 0);

    return '0'.repeat(zerosToAdd) + numStr;
  }

  isoDateToFormattedWithTime(fechaISO: string) {
      // Crear un objeto Date usando la cadena de fecha ISO 8601
      const fecha = new Date(fechaISO);
  
      // Extraer mes y año
      const mes = fecha.getMonth() + 1; // Obtener mes (en formato de 0 a 11, por eso se suma 1)
      const anio = fecha.getFullYear(); // Obtener año
  
      const hora = fecha.getHours();
      const minutos = fecha.getMinutes();
      const segundos = fecha.getSeconds();
  
      // Formatear la fecha como dd/mm/yyyy
      const fechaFormateada = `${fecha.getDate().toString().padStart(2, '0')}/${mes.toString().padStart(2, '0')}/${anio} ${hora.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')}`;
  
      return fechaFormateada;
  }
}