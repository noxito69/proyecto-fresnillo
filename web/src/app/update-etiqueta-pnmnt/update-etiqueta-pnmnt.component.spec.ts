import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UpdateEtiquetaPNMNTComponent } from './update-etiqueta-pnmnt.component';

describe('UpdateEtiquetaPNMNTComponent', () => {
  let component: UpdateEtiquetaPNMNTComponent;
  let fixture: ComponentFixture<UpdateEtiquetaPNMNTComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [UpdateEtiquetaPNMNTComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(UpdateEtiquetaPNMNTComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
