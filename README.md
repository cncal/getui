# A getui sdk package for laravel

[![packagist](https://img.shields.io/packagist/v/cncal/getui.svg?style=flat-square)](https://packagist.org/packages/cncal/getui)
[![downloads](https://img.shields.io/packagist/dt/cncal/getui.svg?style=flat-square)](https://packagist.org/packages/cncal/getui)
[![GitHub license](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://raw.githubusercontent.com/cncal/getui/master/LICENSE)

此扩展包仍在开发中，如有不足与建议，请在 [Issues](https://github.com/cncal/getui/issues) 中告知，感谢支持！

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
'Getui' => Cncal\Getui\Facades\Getui::class,
```

* 发布配置文件 `config/getui.php`：
```php
$ php artisan vendor:publish --provider="Cncal\Getui\GetuiServiceProvider"
```

## 配置
在 `config/getui.php` 中配置推送信息：
```php
// 个推基础信息，在平台新建应用的时候生成
'basic' => [
    'host' => "http://sdk.open.api.igexin.com/apiex.htm",
    'app_id' => "",
    'app_key' => "",
    'master_secret' => "",
],

// 推送消息的基础设置
'push' => [
    'is_ring' => true,  //是否响铃
    'is_vibrate' => true,  // 是否振动
    'is_clearable' => true,  // 是否可清除
    'is_offline' => true,  // 是否发送离线消息
    'offline_expire_time' => 2, // 离线消息过期时间，单位为小时（范围：0- 72），该时间段内 cid 在线过的用户均可收到通知
    'network_type' => 0,  // 是否根据网络环境推送消息，0为不限制推送，1为wifi推送，2为4G/3G/2G
],
```

## 使用
* 函数：
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
 * 推送通知至指定用户列表
 *
 * @param $data
 *
 * @return $rep
 */
Getui::pushMessageToList($data);

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
    * [点击通知打开应用模板](http://docs.getui.com/server/php/template/#1)
    ``` php
    $data = [
        'template_type' => 1,
        'template_type' => [
            'title' => '', // 通知标题，string(40), 必填
            'text'  => '', // 通知内容，string(600), 必填
            'transmission_type'    => 2, // 是否立即启动应用：1 立即启动 2 等待客户端自启动，必填
            'transmission_content' => '', // 透传内容，不支持转义字符，string(2048), 必填
        ]
        'cid' => 'target cid', // 推送通知至指定用户时填写
        'cid_list' => ['cid1','cid2',...], // 推送通知至指定用户列表时填写
    ];
    ```
    * [点击通知打开网页模板](http://docs.getui.com/server/php/template/#2)
        ``` php
        $data = [
            'template_type' => 2,
            'template_type' => [
                'title' => '', // 通知标题，string(40), 必填
                'text'  => '', // 通知内容，string(600), 必填
                'url'   => '', // 点击通知后打开的网页地址，string(200), 必填
            ]
            'cid' => 'target cid', // 推送通知至指定用户时填写
            'cid_list' => ['cid1','cid2',...], // 推送通知至指定用户列表时填写
        ];
        ```
        
    * [点击通知弹窗下载模板](http://docs.getui.com/server/php/template/#3)
        ``` php
        $data = [
            'template_type' => 3,
            'template_type' => [
                'title' => '', // 通知标题，string(40), 必填
                'text'  => '', // 通知内容，string(600), 必填
                'pop_title'   => '', // 弹出框标题，string(40), 必填
                'pop_content' => '', // 弹出框内容，string(600), 必填
                'pop_image'   => '', // 弹出框图标，string(200), 必填
                'load_icon'   => '', // 下载图标: 本地图标[file://]， 网络图标[http:// 或 https://]，string(40), 必填
                'load_title'  => '', // 下载标题，string(40), 必填
                'load_url'    => '', // 下载地址，string(200), 必填
                'is_auto_install' => true, // 是否自动安装（默认否），boolean
                'is_actived'  => false, // 安装完成后是否自动启动应用程序（默认否），boolean
            ]
            'cid' => 'target cid', // 推送通知至指定用户时填写
            'cid_list' => ['cid1','cid2',...], // 推送通知至指定用户列表时填写
        ];
        ```
        
    * [透传消息模版](http://docs.getui.com/server/php/template/#4)
        ``` php
        $data = [
            'template_type' => 4,
            'template_type' => [
                'transmission_type' => 2, // 是否立即启动应用：1 立即启动 2 等待客户端自启动，必填
                'transmission_content' => '', // 透传内容，不支持转义字符，string(2048), 必填
                'is_ios' => false, // 是否支持 ios （默认不支持），boolean
                'is_content_available' => false, // 推送是否直接带有透传数据（默认否）, boolean
                'badge' => '', // 应用icon上显示的数字，int
                'sound' => '', // 通知铃声文件名，string
                'custom_msg' => [
                   'key1' => value1,
                   'key2' => value2,
                   ...
                ], // 增加自定义的数据
                'title' => '', // 通知标题，string
                'text' => true, // 通知内容，string
            ]
            'cid' => 'target cid', // 推送通知至指定用户时填写
            'cid_list' => ['cid1','cid2',...], // 推送通知至指定用户列表时填写
        ];
        ```
    
    * 注意事项：
       * 配置中所有的变量都可以针对于某一条具体的推送自定义值，须放在 `template_data` 节点下
       * 推送可定时展示，开始时间 `start_at` 与结束时间 `end_at` 必须同时设置（格式 `Y-m-d H:i:s`），否则无效
       * 透传消息模版中，当 `is_content_available = false` 时，`title` 与 `text` 必填
       
    * 示例：
       ```php
       $data = [
           'template_type' => 1,
           'template_data' => [
               'title' => 'Laravel Getui',
               'text' => 'May you succeed.',
               'transmission_type' => 1,
               'transmission_content' => 'It is transmission content',
               'is_ring' => false,
               'is_clearable' => false,
               'begin_at' => '2017-08-01 09:00:00',
               'end_at' => '2017-08-02 17:00:00',
           ],
           'cid' => 'target cid',
       ];
       ```
* 返回值 `$rep`
    * [推送结果返回值](http://docs.getui.com/server/php/push/#7)
    
* 版本更新说明：
    * v0.0.3: 修复 ios 透传消息无法增加自定义数据的 bug
    * v0.0.2：向指定的用户列表推送消息
    * v0.0.1：支持个推服务器端 PHP SDK 4.0.1.5
