# la-admin
基于Laravel 6 和 Angular 8 的通用后台,UI使用Ant Design,集成权限管理,二维码,验证码,OAUTH等组件。

## 环境需求

* Node.js >= 10.9.0
* PHP >= 7.2.0
* BCMath PHP 拓展
* Ctype PHP 拓展
* JSON PHP 拓展
* Mbstring PHP 拓展
* OpenSSL PHP 拓展
* PDO PHP 拓展
* Tokenizer PHP 拓展
* XML PHP 拓展

## 集成组件

* endroid/qr-code 二维码
* gregwar/captcha 验证码
* laravel/passport OAuth 认证
* spatie/laravel-permission 权限管理

## 安装

克隆代码

```
git clone https://github.com/donjan-deng/la-admin.git

```
修改配置文件.env.example为.env 并配置好数据库连接。

进入项目执行

```
composer install
php artisan migrate //迁移数据结构
php artisan db:seed //填充初始数据,默认管理员账号密码admin/123456
php artisan key:generate --ansi //生成一个APP_KEY
php artisan passport:keys //生成passport key,如果你需要用到passport
```
进入angular目录执行
```
npm install
npm run build //编译，默认编译至public文件夹
```
将你的Http Server的index优先级配置为index.html > index.php

## 使用

#### angular如何进行开发

编辑angular目录下的proxy.conf.json将target配置为你的php访问地址，并执行
```
npm start
```
#### 如何将angular发布到子目录

修改angular.json
```
"outputPath": "../public",
修改为
"outputPath": "../public/yourpath",
```
编译执行
```
ng build --prod=true --base-href=/yourpath/
```