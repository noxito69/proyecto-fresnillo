import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UpdateEtiquetaComponent } from './update-etiqueta.component';

describe('UpdateEtiquetaComponent', () => {
  let component: UpdateEtiquetaComponent;
  let fixture: ComponentFixture<UpdateEtiquetaComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [UpdateEtiquetaComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(UpdateEtiquetaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
