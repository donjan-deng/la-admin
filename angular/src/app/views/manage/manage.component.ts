import { Component, OnInit, TemplateRef, ViewChild } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ActivatedRoute, Router, NavigationEnd } from '@angular/router';
import { Title } from '@angular/platform-browser';
import { ReuseStrategy } from './manage-reusestrategy.module';

@Component({
  templateUrl: './manage.component.html',
  styles: [
    `
      .trigger {
        font-size: 18px;
        line-height: 46px;
        height:46px;
        padding: 0 24px;
        cursor: pointer;
        transition: color 0.3s;
      }

      .trigger:hover {
        color: #1890ff;
      }

      .logo {
        height: 32px;
        line-height:32px;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        color:rgba(255, 255, 255, 0.698);
        margin: 16px;
      }
      .ant-tabs-tab:focus{
        outline:none;
      }
      .ant-tabs-tab-active {
        border-bottom: 3px solid #1890ff
      }
      .ant-tabs-tab a{
        padding:10px;
        color:rgba(1, 12, 25, 0.68);
      }
      .ant-tabs-tab a:hover{
        color:#1890ff;
      }
      .ant-tabs-tab-active a{
        color:#1890ff;
        font-weight:500;
      }
    `
  ]
})

export class ManageComponent implements OnInit {

  // 路由列表
  menuList = new Array<any>();
  perms: Array<any>;
  menu: Array<any>;
  config; user; permsArr;
  title = 'app';
  isCollapsed = false;
  tabIndex = 1;
  triggerTemplate: TemplateRef<void> | null = null;
  @ViewChild('trigger', { static: false }) customTrigger: TemplateRef<void>;

  constructor(private http: HttpClient, private router: Router, private activatedRoute: ActivatedRoute, private titleService: Title) {

  }
  ngOnInit(): void {
    if (this.router.url === '/manage') { // 主路由默认跳转到index
      this.router.navigate(['/manage/index']);
    }
    this.http.get('/manage/index').subscribe((resp: any) => {
      if (resp.code == 200) {
        this.user = resp.data.user;
        this.perms = resp.data.perms;
        this.config = resp.data.config;
        this.menu = resp.data.menu;
        this.permsArr = resp.data.perms_arr;
        this.pushCurrTab();
        this.onNavigationEnd();
      }
    });
  }
  // 当前路径添加进tab
  pushCurrTab() {
    const currPerm = this.perms.find(e => e.name == this.router.url.substring(1));
    if (currPerm) {
      this.titleService.setTitle(currPerm.display_name);
      this.menuList.push({
        title: currPerm.display_name,
        path: `/${currPerm.name}`,
        select: true
      });
    } else {
      this.menuList.push({
        title: '后台首页',
        path: '/manage/index',
        select: true
      });
    }
  }
  // 订阅路由事件
  onNavigationEnd() {
    this.router.events.subscribe((event) => {
      if (event instanceof NavigationEnd) {
        const path = event.url.substring(1);
        let perm = this.perms.find(e => e.name == path);
        if (!perm) {
          if (path === 'manage/index') {
            perm = {
              name: path,
              display_name: '后台首页'
            };
          } else {
            return;
          }
        }
        this.titleService.setTitle(perm.display_name);
        this.menuList.forEach(p => p.select = false);
        const exitMenu = this.menuList.find(e => e.path == `/${perm.name}`);
        if (exitMenu) {// 如果存在不添加，当前表示选中
          this.menuList.forEach(p => p.select = p.path == exitMenu.path);
          return;
        }
        this.menuList.push({
          title: perm.display_name,
          path: `/${perm.name}`,
          select: true
        });
      }
    });
  }
  // 关闭选项标签
  closeUrl(path, select) {
    // 当前关闭的是第几个路由
    let index = this.menuList.findIndex(p => p.path == path);
    // 如果只有一个不可以关闭
    if (this.menuList.length == 1 || select == false) {
      return;
    }
    this.menuList = this.menuList.filter(p => p.path != path);
    // 删除复用
    delete ReuseStrategy.handlers[path];
    if (!select) {
      return;
    }
    // 显示上一个选中
    index = index === 0 ? 0 : index - 1;
    let menu = this.menuList[index];
    this.menuList.forEach(p => p.select = p.path == menu.module);
    // 显示当前路由信息
    this.router.navigate([menu.path]);
  }
  logout() {
    this.http.get('/manage/logout').subscribe(resp => {
      if (resp['code'] == 200) {
        console.log(window.location.pathname + window.location.hash);
        window.location.reload();
      }
    });
  }
  changeTrigger(): void {
    this.triggerTemplate = this.customTrigger;
  }
}
