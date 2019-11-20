import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { LocationStrategy, HashLocationStrategy, CommonModule } from '@angular/common';

import { ManageRoutingModule } from './views/manage/manage-routing.module';
import { HomeRoutingModule } from './views/home/home-routing.module';

const routes: Routes = [
  { path: '', redirectTo: 'home/index', pathMatch: 'full' },
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes),
    HomeRoutingModule,
    ManageRoutingModule
  ],
  exports: [
    RouterModule
  ],
  providers: [
    { provide: LocationStrategy, useClass: HashLocationStrategy },
  ]
})
export class AppRoutingModule { }
