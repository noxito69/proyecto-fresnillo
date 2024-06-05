import { Routes } from '@angular/router';
import { NewUserPnmntComponent } from './new-user-pnmnt/new-user-pnmnt.component';

export const routes: Routes = [


{path:'', redirectTo: 'home', pathMatch: 'full'},
{path: 'home', loadComponent: () => import('./home/home.component').then(h => h.HomeComponent)},
{path: 'stock', loadComponent: () => import('./stock/stock.component').then(s => s.StockComponent)},
{path:'historial', loadComponent: () => import('./historial/historial.component').then(h => h.HistorialComponent)},
{path:'new-etiqueta', loadComponent: () => import('./new-etiqueta/new-etiqueta.component').then(n => n.NewEtiquetaComponent)},
{path:'update-etiqueta', loadComponent: () => import('./update-etiqueta/update-etiqueta.component').then(u => u.UpdateEtiquetaComponent)},
{path:'new-etiqueta-pnmnt', loadComponent: () => import('./new-etiqueta-pnmnt/new-etiqueta-pnmnt.component').then(ne => ne.NewEtiquetaPNMNTComponent)},
{path:'update-etiqueta-pnmnt', loadComponent: () => import('./update-etiqueta-pnmnt/update-etiqueta-pnmnt.component').then(ue => ue.UpdateEtiquetaPNMNTComponent)},
{path:'new-departamento', loadComponent: () => import('./new-departamento/new-departamento.component').then(nd => nd.NewDepartamentoComponent)},
{path:'new-user-pnmnt', loadComponent: () => import('./new-user-pnmnt/new-user-pnmnt.component').then(nu => nu.NewUserPnmntComponent)},
{path:'register', loadComponent: () => import('./register/register.component').then(r => r.RegisterComponent)},
{path:'login', loadComponent: () => import('./login/login.component').then(l => l.LoginComponent)},
{path:'recover', loadComponent: () => import('./recover/recover.component').then(r => r.RecoverComponent)},
{path:'new-accesorios', loadComponent: () => import('./new-accesorios/new-accesorios.component').then(na => na.NewAccesoriosComponent)},
{path:'llegada-accesorios', loadComponent: () => import('./llegada-accesorios/llegada-accesorios.component').then(la => la.LlegadaAccesoriosComponent)},
{path:'salida-accesorio', loadComponent: () => import('./salida-accesorio/salida-accesorio.component').then(sa => sa.SalidaAccesorioComponent)},
];
