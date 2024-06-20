import { ComponentFixture, TestBed } from '@angular/core/testing';

import { GraficaContratistasComponent } from './grafica-contratistas.component';

describe('GraficaContratistasComponent', () => {
  let component: GraficaContratistasComponent;
  let fixture: ComponentFixture<GraficaContratistasComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [GraficaContratistasComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(GraficaContratistasComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
