## 使用方法
这是一个在laravel上使用发送和验证验证码的工具，可以选择是短信或邮件发送验证码。

#### 安装

1  使用composer安装依赖
```php
composer require ycpfzf/vcode
```

2  发布资源
```php
php artisan vendor:publish
```
在列表中选择 Ycpfzf\Vcode\VcodeServiceProvider，运行完毕会在config文件夹生成配置文件vcode.php


#### 使用

1 短信验证码

使用阿里云的短信，请先在配置文件config/vcode.php中配置好参数
```php
//不指定场景时使用配置文件中 ['sms']['templates']里的 default键指定的模板发送短信
 Ycpfzf\Vcode\Vcode::sms()->name('13800138000')->send();

 //指定场景 login ,必须在配置文件中的 ['sms']['templates']里有login键，并指定模版
 Ycpfzf\Vcode\Vcode::sms()->name('13800138000')->scene('login')->send();
```

2 邮件验证码

使用laravel的Mail发送邮件，所以请先配置后发件参数
```php
//不指定场景时，默认是default,会使用模板resources/vidws/emails/default.blade.php
 Ycpfzf\Vcode\Vcode::email()->name('user@test.com')->subject('验证码')->send();

//使用模板resources/vidws/emails/login.blade.php
 Ycpfzf\Vcode\Vcode::email()->name('user@test.com')->subject('验证码')->scene('login')->send();

 //使用模板resources/vidws/code/login.blade.php
 Ycpfzf\Vcode\Vcode::email()->name('user@test.com')->subject('验证码')->scene('code.login')->send();

 //向模板传递参数，请注意 $code是要发送的验证码
 Ycpfzf\Vcode\Vcode::email()->name('user@test.com')->subject('验证码')->scene('code.login')->assgin($data)->send();
```

3 验证验证码是否正确

```php
if(Ycpfzf\Vcode\Vcode::email()->name('user@test.com')->check(353283)){
    echo '验证成功了';
}else{
    echo '验证码不正确';
}

//如果是短信验证码，将上面的email()方法换成sms()
```

4 使用队列发送

请先配置好队列，否则可能返回发送成功，但实际没有发送
```php
 Ycpfzf\Vcode\Vcode::sms()->name('13800138000')->queue();
 Ycpfzf\Vcode\Vcode::email()->name('user@test.com')->subject('验证码')->queue();
```


