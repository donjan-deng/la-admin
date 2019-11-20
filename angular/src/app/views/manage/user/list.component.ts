import { Component } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { formatDate } from '@angular/common';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ManageComponent } from '../manage.component';
import { Helper } from '../../../helpers/helper';

@Component({
  templateUrl: './list.component.html',
})

export class UserListComponent {
  params = {
    username: '',
    phone: '',
    status: '',
    start_time: '',
    end_time: '',
    date_range: [],
    page: '1',
    per_page: '15',
    total: '1',
    sort_name: '',
    sort_value: ''
  };
  list = [];
  roleList = [];
  pageSizeOption = [15, 25, 50];
  dialog = {
    visible: false,
    loading: false
  };
  roleDialog = {
    visible: false,
    loading: false
  };
  form = this.fb.group({
    user_id: [],
    username: ['', Validators.required],
    password: [],
    confirm_password: [],
    real_name: ['', Validators.required],
    sex: [],
    phone: ['', Validators.required],
    status: []
  });
  roleForm = this.fb.group({
    user_id: [],
    username: [],
    roles: []
  });
  constructor(private http: HttpClient, public app: ManageComponent, private fb: FormBuilder) {
    this.init();
  }
  init() {
    this.getList();
    this.getRoleList();
  }
  getList() {
    const httpParams = new HttpParams({ fromObject: this.params });
    this.http.get('/manage/user/list', { params: httpParams }).subscribe((resp: any) => {
      this.list = resp.data.data;
      this.params.total = resp.data.total;
      this.params.per_page = resp.data.per_page;
      this.params.page = resp.data.current_page;
    });
  }
  getRoleList() {
    const httpParams = new HttpParams({ fromObject: {} });
    this.http.get('/manage/role/search', { params: httpParams }).subscribe((resp: any) => {
      this.roleList = [];
      for (let r of resp.data) {
        this.roleList.push({
          label: r.name,
          value: r.id
        });
      }
    });
  }
  add() {
    Helper.resetForm(this.form);
    this.form.get('user_id').setValue(0);
    this.form.get('status').setValue(1);
    this.form.get('sex').setValue(1);
    this.form.get('username').reset({ value: '', disabled: false });
    this.dialog.visible = true;
  }
  edit(model) {
    Helper.resetForm(this.form);
    this.form.patchValue(model);
    this.form.get('username').reset({ value: model.username, disabled: true });
    this.dialog.visible = true;
  }
  save() {
    Helper.validateForm(this.form);
    if (this.form.valid) {
      this.dialog.loading = true;
      const data = this.form.value;
      if (data.user_id > 0 && !data.username) { // 设disabled后不会传值
        data.username = '111';
      }
      this.http.post('/manage/user/edit', this.form.value).subscribe((resp: any) => {
        if (resp.code == 200) {
          this.dialog.visible = false;
          this.getList();
        }
        this.dialog.loading = false;
      },
        error => {
          this.dialog.loading = false;
        });
    }
  }
  close() {
    this.dialog.visible = false;
    this.dialog.loading = false;
  }
  editRole(model) {
    Helper.resetForm(this.roleForm);
    this.roleList.forEach(e => {
      e.checked = model.roles.findIndex(q => q.id === e.value) >= 0;
    });
    this.roleForm.get('username').reset({ value: model.username, disabled: true });
    this.roleForm.get('user_id').setValue(model.user_id);
    this.roleForm.get('roles').setValue(this.roleList);
    this.roleDialog.visible = true;
  }
  saveRole() {
    this.roleDialog.loading = true;
    const roles = [];
    this.roleForm.get('roles').value.forEach(q => {
      if (q.checked) {
        roles.push(q.value);
      }
    });
    // tslint:disable-next-line:object-literal-shorthand
    this.http.post('/manage/role/attach', { user_id: this.roleForm.get('user_id').value, roles: roles }).subscribe((resp: any) => {
      if (resp.code == 200) {
        this.roleDialog.visible = false;
        this.getList();
      }
      this.roleDialog.loading = false;
    },
      error => {
        this.roleDialog.loading = false;
      });
  }
  closeRole() {
    this.roleDialog.visible = false;
    this.roleDialog.loading = false;
  }
  selectDate() {
    if (this.params.date_range.length > 0) {
      this.params.start_time = formatDate(this.params.date_range[0], 'yyyy-MM-dd 00:00:00', 'zh');
      this.params.end_time = formatDate(this.params.date_range[1], 'yyyy-MM-dd 23:59:59', 'zh');
    } else {
      this.params.start_time = '';
      this.params.end_time = '';
    }
    this.search();
  }
  search() {
    this.params.page = '1';
    this.getList();
  }
  goPage(page) {
    this.params.page = page;
    this.search();
  }
  changePageSize(size) {
    this.params.page = '1';
    this.params.per_page = size;
    this.search();
  }
  sort(name, value) {
    this.params.page = '1';
    this.params.sort_name = name;
    this.params.sort_value = value;
    this.search();
  }
}
