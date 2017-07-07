<?php

return [
    /**
     * 个推基础信息
     */
    'basic_info' => [
        'host' => "http://sdk.open.api.igexin.com/apiex.htm",
        'app_id' => "",
        'app_key' => "",
        'master_secret' => "",
    ],

    /**
     * 推送基础信息
     */
    'push_info' => [
        'is_offline' => true,
        'offline_expire_time' => 3600 * 1000 * 2, // 单位为毫秒
        'network_type' => 0 // 设置是否根据WIFI推送消息, 0为不限制推送, 1为wifi推送, 2为4G/3G/2G
    ],

];
