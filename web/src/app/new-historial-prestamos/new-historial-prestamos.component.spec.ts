import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewHistorialPrestamosComponent } from './new-historial-prestamos.component';

describe('NewHistorialPrestamosComponent', () => {
  let component: NewHistorialPrestamosComponent;
  let fixture: ComponentFixture<NewHistorialPrestamosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NewHistorialPrestamosComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(NewHistorialPrestamosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
