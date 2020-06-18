## 使用方法
这是一个在laravel上使用发送和验证验证码的工具，可以选择是短信或邮件发送验证码。

#### 安装

1  使用composer安装依赖
```
composer require ycpfzf/vcode
```

2  发布资源
````
php artisan vendor:publish
````
在列表中选择 Ycpfzf\Apidoc\DocServiceProvider，运行完毕会在config文件夹生成配置文件vcode.php


#### 使用

1 短信验证码
````
 
````

2 邮件验证码
````
 
````

3 验证验证码是否正确
````

````

4 使用队列发送
````

````


