import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewAccesoriosComponent } from './new-accesorios.component';

describe('NewAccesoriosComponent', () => {
  let component: NewAccesoriosComponent;
  let fixture: ComponentFixture<NewAccesoriosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NewAccesoriosComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(NewAccesoriosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
