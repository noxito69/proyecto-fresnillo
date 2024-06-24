import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PostImpresorasComponent } from './post-impresoras.component';

describe('PostImpresorasComponent', () => {
  let component: PostImpresorasComponent;
  let fixture: ComponentFixture<PostImpresorasComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [PostImpresorasComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(PostImpresorasComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
