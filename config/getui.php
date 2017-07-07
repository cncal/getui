<?php

return [
    /**
     * 个推基础信息
     */
    'basic_info' => [
        'host' => "http://sdk.open.api.igexin.com/apiex.htm",
        'app_id' => "A2jmZ6lrWw5VWQ5SPGr258",
        'app_key' => "wfOhPKrLLK9zzcTtPM86z5",
        'master_secret' => "cUh0xehU259Zz6AB92Rh23",
    ],

    /**
     * 推送基础信息
     */
    'push_info' => [
        'is_offline' => true,
        'offline_expire_time' => 3600*1000*2, // 单位为毫秒
        'network_type' => 0 // 设置是否根据WIFI推送消息, 0为不限制推送, 1为wifi推送, 2为4G/3G/2G
    ],

];