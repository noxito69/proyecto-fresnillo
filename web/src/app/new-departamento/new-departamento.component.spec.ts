import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewDepartamentoComponent } from './new-departamento.component';

describe('NewDepartamentoComponent', () => {
  let component: NewDepartamentoComponent;
  let fixture: ComponentFixture<NewDepartamentoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NewDepartamentoComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(NewDepartamentoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
