# Translug

>来源于 translate 和 slug 这两个词的组合,目的是实现文章和帖子中文标题也可以使用 slug 类型的 url 。

## 安装

这是一个标准的 Composer 的包,你可以直接通过下面的命令行来安装:

```bash
composer require jellybool/translug
```
或者在你的 `composer.json` 文件中添加:

```json
"jellybool/translug" : "~1.0"
```
然后执行 `composer update`

## 初始化

在 Translug 中,翻译的功能是直接使用有道的 API,你首先需要在这里注册你的网站或者 App:

http://fanyi.youdao.com/openapi?path=data-mode

> 不用担心,非常简单!

注册之后,你会拿到两个关键的信息:
```
1. api key
2. key from
```

### Laravel 中使用
**1.配置**
默认情况在,在 laravel 项目中的 `config/services.php` 中添加:

```php
  'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
   // 下面是你添加的内容
  'youdao' => [
        'key' => env('YOUDAO_API_KEY'),
        'from' => env('YOUDAO_KEY_FROM'),
    ],
```
当然,你还需要在 `.env` 文件中添加:
```php
YOUDAO_API_KEY=your_key
YOUDAO_KEY_FROM=your_from
```

在 `config/app.php` 中,添加 `provider` 和 `aliases` :

```php
 //provider
 \JellyBool\Translug\TranslugServiceProvider::class,

// aliases
'Translug' => \JellyBool\Translug\TranslugFacade::class,
```

**2.使用**
```php
app('translug')->translate('如何安装 Laravel'); // or Translug::translate('如何安装 Laravel');
//How to install the Laravel

app('translug')->translug('如何安装 Laravel'); // or Translug::translug('如何安装 Laravel');
//how-to-install-the-laravel

//或者你只想要 slug 的话

translug('如何安装 Laravel');
//how-to-install-the-laravel
```

### 在普通的项目使用

**1.设置 api key 和 from**

```php
use namespace JellyBool\Translug\Translug;

$translug = new Translug(['keyfrom'=>'your_key_from','key'=>'your_api_key']);
// 或者也可以这样
$translug = new Translug();
$translug->setConfig(['keyfrom'=>'your_key_from','key'=>'your_api_key']);
```

**2.使用**

```php
$translug->translate('如何安装 Laravel');
//How to install the Laravel

$translug->translug('如何安装 Laravel');
//how-to-install-the-laravel
```


