import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { BrowserModule } from '@angular/platform-browser';
import { CommonModule } from '@angular/common';
import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';

import { IndexComponent } from './index/index.component';

const routes: Routes = [
  {
    path: 'home/index',
    component: IndexComponent,
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
    BrowserModule,
    CommonModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  exports: [
    RouterModule
  ],
  declarations: [
    IndexComponent
  ],
  providers: [
  ]
})
export class HomeRoutingModule { }
