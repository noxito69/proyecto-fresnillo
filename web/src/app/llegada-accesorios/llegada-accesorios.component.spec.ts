import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LlegadaAccesoriosComponent } from './llegada-accesorios.component';

describe('LlegadaAccesoriosComponent', () => {
  let component: LlegadaAccesoriosComponent;
  let fixture: ComponentFixture<LlegadaAccesoriosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [LlegadaAccesoriosComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(LlegadaAccesoriosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
