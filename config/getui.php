<?php

return [
    /**
     * 个推基础配置
     */
    'basic' => [
        'host' => "http://sdk.open.api.igexin.com/apiex.htm",
        'app_id' => "",
        'app_key' => "",
        'master_secret' => "",
    ],

    /**
     * 推送基础配置
     */
    'push' => [
        'is_ring' => true,  // 是否响铃
        'is_vibrate' => true,  // 是否振动
        'is_clearable' => true,  // 是否可清除
        'is_offline' => true,  // 是否发送离线消息
        'offline_expire_time' => 2, // 离线消息过期时间，单位为小时（范围：0- 72），该时间段内 cid 在线过的用户均可收到通知
        'network_type' => 0,  // 是否根据网络环境推送消息，0为不限制推送，1为wifi推送，2为4G/3G/2G
    ],

    /**
     * 队列配置
     */
    'queue' => [
        'is_used' => false, // 是否使用队列
        'connection' => env('QUEUE_DRIVER', 'sync'), // 连接
        'queue' => 'default', // 队列
    ],
];
