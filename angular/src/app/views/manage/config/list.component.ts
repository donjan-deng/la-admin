import { Component } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { FormBuilder } from '@angular/forms';
import { NzMessageService } from 'ng-zorro-antd';
import { ManageComponent } from '../manage.component';
import { Helper } from '../../../helpers/helper';

@Component({
  templateUrl: './list.component.html',
})

export class ConfigListComponent {
  params = {
    page: '1',
    per_page: '25',
    total: '1',
    sort_name: '',
    sort_value: ''
  };
  list = [];
  pageSizeOption = [15, 25, 50];
  dialog = {
    visible: false,
    loading: false
  };
  form = this.fb.group({
    key: [],
    type: [],
    description: [],
    value: []
  });
  constructor(private http: HttpClient, public app: ManageComponent, private fb: FormBuilder, private message: NzMessageService) {
    this.init();
  }
  init() {
    this.getList();
  }
  getList() {
    const httpParams = new HttpParams({ fromObject: this.params });
    this.http.get('/manage/config/list', { params: httpParams }).subscribe((resp: any) => {
      this.list = resp.data.data;
      this.params.total = resp.data.total;
      this.params.per_page = resp.data.per_page;
      this.params.page = resp.data.current_page;
    });
  }
  edit(model) {
    Helper.resetForm(this.form);
    this.form.patchValue(model);
    if (model.type === 'array' && Array.isArray(model.value)) {
      this.form.get('value').setValue(model.value.join('\n'));
    } else if (model.type === 'json' && typeof (model.value) === 'object') {
      this.form.get('value').setValue(JSON.stringify(model.value));
    }
    this.dialog.visible = true;
  }
  save() {
    Helper.validateForm(this.form);
    if (this.form.valid) {
      // tslint:disable-next-line:prefer-const
      let data = this.form.value;
      switch (data.type) {
        case 'array':
          data.value = data.value.split('\n');
          break;
        case 'json':
          try {
            data.value = JSON.parse(data.value);
          } catch (e) {
            this.message.create('error', `错误的数据格式`);
            return false;
          }
          break;
      }
      this.dialog.loading = true;
      this.http.post('/manage/config/edit', this.form.value).subscribe((resp: any) => {
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
