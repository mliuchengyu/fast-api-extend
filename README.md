# fast-api/extend
fast-api/extend 是一个快速生成构建Composer Packages包的处理和操作库，它提供了一种更容易表达的方式来创建，该软件包包括用于轻松集成Laravel的ServiceProviders和Facades 。

更多功能可以参考下面的文档。

在Laravel应用程序中使用官方fast-api/extend客户端的简便方法。



- [安装与配置](#安装与配置)
    - [安装 Laravel](#安装-Laravel)
        - [安装 fast-api/extend](#安装-扩展包)
        - [发布配置](#发布配置)
        - [生成扩展包](#生成扩展包)
- [存储库](#存储库)
- [bug、建议、贡献和支持](#bug-建议-贡献和支持)
- [版权和许可](#版权和许可)


## 安装与配置

<h1 align="center">Fast-php Cloud Fast-api/Extend SDK for Laravel</h1>

## 安装 Laravel

本产品依赖Laravel需要安装 Laravel `laravel/laravel` package via composer:

```sh
composer create-project --prefer-dist laravel/laravel laravel "7.30.0"
```

## 安装 扩展包

```sh
composer require fast-api/extend dev-master
```

## 发布配置

```sh
php artisan vendor:publish --provider "Prettus\Repository\Providers\RepositoryServiceProvider"
```

## 生成扩展包

```sh
php artisan make:fast-extend-packs User --package="fast-api-demo"
```

## bug 建议 贡献和支持

请使用[Github](https://github.com/fast-php/fast-api-extend)报告bug，并提出意见或建议。

请参阅[CONTRIBUTING.md](CONTRIBUTING.md)了解如何贡献更改。


## 文档
PHP开发技术交流（QQ群 368868750）

[![PHP开发技术交流 (SDK)](http://pub.idqqimg.com/wpa/images/group.png)](https://qm.qq.com/cgi-bin/qm/qr?k=rfRumoZ0fxUN4TdshfjkxiHximnHVSzb&jump_from=webapi)

> fast-api-extend 是基于laravel 7.x 封装，在做项目开发前，必需先阅读laravel官方文档。
>* laravel 官方文档：https://learnku.com/docs/laravel/7.x/releases/7444

## 存储库
fast-api-extend 为开源项目，允许把它用于任何地方，不受任何约束，欢迎 fork 项目。
>* GitHub 托管地址：https://github.com/fast-oopdev/fast-api-extend
>* packagist 托管地址：https://packagist.org/packages/fast-api/extend
>
## 版权和许可

[fast-api/extend](https://github.com/fast-oopdev/fast-api-permission)
was written by [fast-php](http://www.dnat.link) and is released under the
[MIT License](LICENSE.md).

Copyright (c) 2021 fast-php
