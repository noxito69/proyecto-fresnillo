import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SalidaAccesorioComponent } from './salida-accesorio.component';

describe('SalidaAccesorioComponent', () => {
  let component: SalidaAccesorioComponent;
  let fixture: ComponentFixture<SalidaAccesorioComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SalidaAccesorioComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(SalidaAccesorioComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
