import { NgModule } from '@angular/core';
import { Routes, RouterModule, RouteReuseStrategy } from '@angular/router';
import { NgZorroAntdModule, NZ_I18N, zh_CN, NZ_MESSAGE_CONFIG } from 'ng-zorro-antd';
import { registerLocaleData, CommonModule } from '@angular/common';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { ReuseStrategy } from './manage-reusestrategy.module';
import { AuthInterceptor } from './manage-auth-interceptor.module';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { BrowserModule } from '@angular/platform-browser';
import zh from '@angular/common/locales/zh';
// helper
import { ArrayToStringPipe } from '../../helpers/pipes';
import { CanDirective, SortTableDirective } from '../../helpers/directive';
//通用
import { ManageComponent } from './manage.component';
import { IndexComponent } from './index/index.component';
import { LoginComponent } from './index/login.component';
// 系统管理
import { UserListComponent } from './user/list.component';
import { RoleListComponent } from './role/list.component';
import { ConfigListComponent } from './config/list.component';

registerLocaleData(zh);

const routes: Routes = [
  {
    path: 'manage',
    component: ManageComponent,
    children: [
      { path: 'index', component: IndexComponent, },
      { path: 'user/list', component: UserListComponent },
      { path: 'role/list', component: RoleListComponent },
      { path: 'config/list', component: ConfigListComponent }
    ]
  },
  {
    path: 'manage/login',
    component: LoginComponent,
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(routes),
    BrowserModule,
    CommonModule,
    NgZorroAntdModule,
    HttpClientModule,
    FormsModule,
    ReactiveFormsModule
  ],
  exports: [
    RouterModule
  ],
  declarations: [
    ManageComponent,
    IndexComponent,
    LoginComponent,
    UserListComponent,
    RoleListComponent,
    ConfigListComponent,
    // helper
    ArrayToStringPipe,
    CanDirective,
    SortTableDirective
  ],
  providers: [
    { provide: NZ_I18N, useValue: zh_CN },
    { provide: RouteReuseStrategy, useClass: ReuseStrategy },
    { provide: NZ_MESSAGE_CONFIG, useValue: { nzDuration: 4000, nzTop: 200 } },
    { provide: HTTP_INTERCEPTORS, useClass: AuthInterceptor, multi: true }
  ]
})
export class ManageRoutingModule { }
