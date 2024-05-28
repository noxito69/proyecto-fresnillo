import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NewUserPnmntComponent } from './new-user-pnmnt.component';

describe('NewUserPnmntComponent', () => {
  let component: NewUserPnmntComponent;
  let fixture: ComponentFixture<NewUserPnmntComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NewUserPnmntComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(NewUserPnmntComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
