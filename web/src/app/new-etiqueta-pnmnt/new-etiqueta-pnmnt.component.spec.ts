import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewEtiquetaPNMNTComponent } from './new-etiqueta-pnmnt.component';

describe('NewEtiquetaPNMNTComponent', () => {
  let component: NewEtiquetaPNMNTComponent;
  let fixture: ComponentFixture<NewEtiquetaPNMNTComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NewEtiquetaPNMNTComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(NewEtiquetaPNMNTComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
