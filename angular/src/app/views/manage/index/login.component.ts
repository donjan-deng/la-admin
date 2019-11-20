import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { Helper } from '../../../helpers/helper';

@Component({
  templateUrl: './login.component.html',
  styles: [
    `
      .login-form {
        max-width: 400px;
        margin:10% auto;
      }

      .login-form-forgot {
        float: right;
      }

      .login-form-button {
        width: 100%;
      }
    `
  ]
})

export class LoginComponent implements OnInit {

  loginForm: FormGroup;
  captchaUrl = '/home/captcha?width=100&height=40';

  constructor(private http: HttpClient, private router: Router, private fb: FormBuilder) { }

  ngOnInit() {
    this.loginForm = this.fb.group({
      username: ['', [Validators.required]],
      password: ['', [Validators.required]],
      captcha: ['', [Validators.required]],
      remember: [true]
    });
  }
  submitForm() {
    Helper.validateForm(this.loginForm);
    if (this.loginForm.valid) {
      this.http.post('/manage/login', this.loginForm.value).subscribe(data => {
        if (data['code'] && data['code'] == 200) {
          this.router.navigate(['/manage/index'], { queryParams: { refresh: true } });
        } else {
          this.refreshCaptcha();
        }
      },
        error => {
          this.refreshCaptcha();
        });
    }
    //批量赋值
    // this.profileForm.patchValue({
    //   firstName: 'Nancy',
    //   address: {
    //     street: '123 Drew Street'
    //   }
    // });
  }
  refreshCaptcha() {
    this.captchaUrl += '&time=' + (new Date()).getTime();
  }
}
