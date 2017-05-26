# Translug

[![Build Status](https://travis-ci.org/JellyBool/translug.svg?branch=master)](https://travis-ci.org/JellyBool/translug)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/JellyBool/translug/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/JellyBool/translug/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/JellyBool/translug/badges/build.png?b=master)](https://scrutinizer-ci.com/g/JellyBool/translug/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/JellyBool/translug/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/JellyBool/translug/?branch=master)
[![StyleCI](https://styleci.io/repos/68300128/shield?branch=master)](https://styleci.io/repos/68300128)
[![Total Downloads](https://poser.pugx.org/JellyBool/translug/downloads)](https://packagist.org/packages/JellyBool/translug)
[![Latest Stable Version](https://poser.pugx.org/JellyBool/translug/version)](https://packagist.org/packages/JellyBool/translug)
[![License](https://poser.pugx.org/JellyBool/translug/license)](https://packagist.org/packages/JellyBool/translug)

>来源于 translate 和 slug 这两个词的组合,目的是实现文章和帖子中文标题也可以使用 slug 类型的 url 。

## Demo
Laravel 技术问答社区: https://laravist.com/discuss ,随便点开一个问答帖子就可以看效果。

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

在 Translug 中,翻译的功能是直接使用有道翻译 API ,你首先需要在这里注册你的网站或者 App:

* ~~http://fanyi.youdao.com/openapi?path=data-mode~~        旧版接口, 有道不再支持
* http://ai.youdao.com/docs/api.s


> 不用担心,非常简单! 有道翻译的免费接口限制为~~每小时最多 1000 次请求~~每天有十万免费字符,如果需要更多 API 调用,请联系有道官方。

注册之后,你会拿到两个关键的信息:
```
1. api key
2. key from
```
**新的接口注册后会拿到两个关键信息**
```
1. app key
2. app secret
```

### 1.Laravel 中使用
**1.1 配置**
默认情况在,在 laravel 项目中的 `config/services.php` 中添加:
**所有配置中新版本与旧版本配置一种就行, 两种配置都有的情况下使用新版接口**

```php
  'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
   // 下面是你添加的内容,
  'youdao' => [
        'key' => env('YOUDAO_API_KEY'),             //旧版的API的配置
        'from' => env('YOUDAO_KEY_FROM'),           //旧版的API的配置
        'appKey' => env('YOUDAO_APP_KEY'),          //新版的AIP配置
        'appSecret' => env('YOUDAO_APP_SECRET'),    //新版的AIP配置
    ],
```
当然,你还需要在 `.env` 文件中添加:
```php
YOUDAO_API_KEY=your_key             //旧版API的配置
YOUDAO_KEY_FROM=your_from           //旧版API的配置
YOUDAO_APP_KEY=your_app_key         //新版API的配置
YOUDAO_APP_SECRET=your_app_secret   //新版API的配置
```

在 `config/app.php` 中,添加 `provider` 和 `aliases` :

```php
 //provider
 \JellyBool\Translug\TranslugServiceProvider::class,

// aliases
'Translug' => \JellyBool\Translug\TranslugFacade::class,
```

**1.2 使用**
```php
app('translug')->translate('如何安装 Laravel');
//How to install the Laravel

// or
use Translug;
Translug::translate('如何安装 Laravel');
//How to install the Laravel

app('translug')->translug('如何安装 Laravel');
//how-to-install-the-laravel

// or
use Translug;
Translug::translug('如何安装 Laravel');
//how-to-install-the-laravel

//或者你只想要 slug 的话

translug('如何安装 Laravel');
//how-to-install-the-laravel

translug('怎么理解 laravel 关联模型');
//how-to-understand-the-laravel-associated-model

//針對繁體,翻譯會有一點不一樣
translug('怎麼理解 laravel 關聯模型');
//how-to-understand-the-laravel-correlation-model
```

### 2.在普通的项目使用

**2.1 设置 api key 和 from**

```php
use JellyBool\Translug\Translug;

$translug = new Translug(['keyfrom'=>'your_key_from','key'=>'your_api_key']);
// 或者也可以这样
$translug = new Translug();
$translug->setConfig(['keyfrom'=>'your_key_from','key'=>'your_api_key']);
```

**2.2 使用**

```php
$translug->translate('如何安装 Laravel');
//How to install the Laravel

$translug->translug('如何安装 Laravel');
//how-to-install-the-laravel
```


