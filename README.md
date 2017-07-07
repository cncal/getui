# A getui sdk package for laravel

<p align="left">
<a href="https://packagist.org/packages/cncal/getui"><img src="https://poser.pugx.org/cncal/getui/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/cncal/getui"><img src="https://poser.pugx.org/cncal/getui/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/cncal/getui"><img src="https://poser.pugx.org/cncal/getui/license.svg" alt="License"></a>
</p>

此扩展包仍在开发中，对于预配项及对模板的支持在持续优化中，如有不足，请在 [Issues](https://github.com/cncal/getui/issues) 中告知，感谢支持！

## 依赖
* Laravel 5 +
* cUrl

## 安装
* 执行命令： 
```sh
$ composer require cncal/getui
```

* 添加 `GetuiServiceProvider` 至 `config/app` 的 `providers`：
```php
Cncal\Getui\GetuiServiceProvider::class,
```

* 添加 Facade 至 `config/app` 的 `aliases`：
```php
Cncal\Getui\Facades\Getui::class,
```

* 发布配置文件 `config/getui.php`：
```php
$ php artisan vendor:publish --provider="Cncal\Getui\GetuiServiceProvider"
```

## 配置
在 `config/getui.php` 中配置推送信息：
```php
    // 个推基础信息，在平台新建应用的时候生成
    'basic_info' => [
        'host' => "http://sdk.open.api.igexin.com/apiex.htm",
        'app_id' => "",
        'app_key' => "",
        'master_secret' => "",
    ],

    // 推送消息的基础设置
    'push_info' => [
        'is_offline' => true, // 是否发送离线消息
        'offline_expire_time' => 3600*1000*2, // 离线消息过期时间，单位为毫秒
        'network_type' => 0 // 是否根据网络环境推送消息, 0为不限制推送, 1为wifi推送, 2为4G/3G/2G
    ],
```

## 使用
* 方法：
```php
<?php 
use Getui;

/**
 * 推送通知至指定用户
 *
 * @param $data
 *
 * @return $rep
 */
Getui::pushMessageToSingle($data);


/**
 * 推送通知至该应用的所有用户
 *
 * @param $data
 *
 * @return $rep
 */
Getui::pushMessageToApp($data);

```

* 入参 `$data`
    * `template_type`
       * 1: [点击通知打开应用模板](http://docs.getui.com/server/php/template/#1)
       * 2: [点击通知打开网页模板](http://docs.getui.com/server/php/template/#2)
       * 3: [点击通知弹窗下载模板](http://docs.getui.com/server/php/template/#3)（暂不支持）
       * 4: [透传消息模版](http://docs.getui.com/server/php/template/#4)（暂不支持）
       
    * `template_data`
       * 当 `'template_type' = 1` 时：    
             
        | 字段 | 长度 | 是否必填 | 说明 | 
        | ----------- | :---: | :---: | :---------: |
        | title | 40中/英字符 | 是 | 通知标题 |
        | text | 600中/英字符 | 是 | 通知内容 |
        | transmission_type |  | 是 | 收到消息是否立即启动应用：1为立即启动，2则广播等待客户端自启动 |
        | transmission_content | 2048中/英字符 | 是 | 透传内容，不支持转义字符 |
        | is_ring |  | 否 | 收到通知是否响铃，默认响铃 |
        | is_vibrate |  | 否 | 收到通知是否振动，默认振动 |
        | is_clearable |  | 否 | 通知是否可清除，默认可清除 |
        | begin_time |  | 否 | 消息展示开始时间 |
        | end_time |  | 否 | 消息展示结束时间 |
      
       * 当 `'template_type' = 2` 时：  
       
        | 字段 | 长度 | 是否必填 | 说明 | 
        | ----------- | :---: | :---: | :---------: |
        | title | 40中/英字符 | 是 | 通知标题 |
        | text | 600中/英字符 | 是 | 通知内容 |
        | url | 200中/英字符 | 是 | 点击通知后打开的网页地址 |
        | is_ring |  | 否 | 收到通知是否响铃，默认响铃 |
        | is_vibrate |  | 否 | 收到通知是否振动，默认振动 |
        | is_clearable |  | 否 | 通知是否可清除，默认可清除 |
        | begin_time |  | 否 | 消息展示开始时间 |
        | end_time |  | 否 | 消息展示结束时间 |
    
    * `cid`：推送通知至指定用户时填写
    
    * 示例：
       ```php
       $data = [
           'template_type' => 1,
           'template_data' => [
               'title' => 'Laravel Getui',
               'text' => 'May you succeed.',
           ],
           'cid' => 'your cid',
       ];
       ```
* 返回值 `$rep`
    * [推送结果返回值](http://docs.getui.com/server/php/push/#7)