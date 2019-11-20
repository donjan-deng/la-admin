// 拦截器
import { Injectable } from '@angular/core';
import { HttpEvent, HttpInterceptor, HttpHandler, HttpRequest } from '@angular/common/http';
import { Observable } from 'rxjs';
import { HttpResponse } from '@angular/common/http';
import { tap } from 'rxjs/operators';
import { Router } from '@angular/router';
import { HttpErrorResponse } from '@angular/common/http';
import { NzMessageService, NzNotificationService, NzModalService } from 'ng-zorro-antd';

@Injectable()
export class AuthInterceptor implements HttpInterceptor {

  // tslint:disable-next-line:max-line-length
  constructor(private router: Router, private message: NzMessageService, private notification: NzNotificationService, private modalService: NzModalService) {

  }
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
    return next.handle(req).pipe(
      tap(event => {
        if (event instanceof HttpResponse) {
          if (event.body.code != 200) {
            // this.message.create('warning', event.body['message']);
            this.modalService.warning({
              nzTitle: 'Warning',
              nzContent: event.body.message
            });
          }
        }
      }, error => {
        if (error instanceof HttpErrorResponse) {
          if (error.status == 401) {
            this.router.navigate(['/manage/login']);
          } else if (error.status == 500) {
            this.notification.create('error', '出错拉', '请求失败,请刷新页面试一试');
          } else if (error.status == 504) {
            this.notification.create('error', '重要提醒', '你当前的网络不稳定哦！');
          } else {
            // this.message.create('warning', error.error['message']);
            this.modalService.error({
              nzTitle: 'Error',
              nzContent: error.error.message
            });
          }
        } else {
          this.notification.create('error', '出错拉', '网络请求错误,请刷新页面试一试');
        }
      })
    )
  }
}