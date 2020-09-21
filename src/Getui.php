<?php

namespace Cncal\Getui;

use Cncal\Getui\Sdk\IGtPush;
use Cncal\Getui\Sdk\IGetui\IGtTarget;
use Cncal\Getui\Jobs\PushGetuiMessage;
use Cncal\Getui\Sdk\IGetui\IGtAppMessage;
use Cncal\Getui\Sdk\IGetui\IGtListMessage;
use Cncal\Getui\Sdk\IGetui\IGtSingleMessage;
use Cncal\Getui\Sdk\IGetui\Template\GetuiTemplate;

class Getui
{
    protected $app;
    /**
     * @var string
     */
    protected $app_id;

    /**
     * @var IGtPush
     */
    protected $igt;

    /**
     * Whether or not send offline message.
     *
     * @var bool;
     */
    protected $is_offline;

    /**
     * Offline message expire time.
     *
     * @var int
     */
    protected $offline_expire_time;

    /**
     * Network type.
     *
     * @var int
     */
    protected $network_type;

    /**
     * Whether or not use queue.
     *
     * @var bool
     */
    protected $queue_is_used;

    /**
     *  Queue connection will be used.
     *
     * @var string
     */
    protected $queue_connection;

    /**
     * Queue will be used.
     *
     * @var string
     */
    protected $queue_queue;

    /**
     * Getui constructor.
     */
    public function __construct($app = 'basic')
    {
        $config = config('getui');
        if(empty($config[$app] ?? '')){
            throw new \Exception('getui app not exists');
        }
        $this->app = $app;
        $this->app_id = $config[$app]['app_id'];
        $this->igt = new IGtPush($config[$app]['host'], $config[$app]['app_key'], $config[$app]['master_secret']);
        $this->is_offline = $config['push']['is_offline'];
        $this->offline_expire_time = $config['push']['offline_expire_time'];
        $this->network_type = $config['push']['network_type'];
        $this->queue_is_used = $config['queue']['is_used'];
        $this->queue_connection = $config['queue']['connection'];
        $this->queue_queue = $config['queue']['queue'];
    }

    /**
     * Push message to single user.
     *
     * @param $data
     *
     * @return bool|\Cncal\Getui\Sdk\Array
     */
    public function pushMessageToSingle($data)
    {
        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];
        $cid = $data['cid'];

        $is_off_line = isset($data['template_data']['is_offline']) ?
                       (bool)$data['template_data']['is_offline'] : $this->is_offline;

        $offline_expire_time = isset($data['template_data']['is_offline']) ?
                               (int)$data['template_data']['offline_expire_time'] * 1000 * 3600 :
                               $this->offline_expire_time * 1000 * 3600;

        $network_type = isset($data['template_data']['network_type']) ?
                        (int)$data['template_data']['network_type'] : $this->network_type;

        // todo: need to discuss
        $getui_template = new GetuiTemplate($this->app, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtSingleMessage();
        $message->set_isOffline($is_off_line);

        if ($is_off_line) {
            $message->set_offlineExpireTime($offline_expire_time);
        }

        $message->set_pushNetWorkType($network_type);
        $message->set_data($template);

        // 接收方
        $target = new IGtTarget();
        $target->set_appId($this->app_id);
        $target->set_clientId($cid);

        // 使用队列
        if ($this->queue_is_used) {
            PushGetuiMessage::dispatch($this->igt, 'pushMessageToSingle', $message, $target)
                            ->onConnection($this->queue_connection)
                            ->onQueue($this->queue_queue);

            return true;
        }

        $rep = $this->igt->pushMessageToSingle($message, $target);

        return $rep;
    }

    /**
     * Push message to user list
     *
     * @param $data
     *
     * @return mixed|null
     */
    public function pushMessageToList($data)
    {
        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];

        $is_off_line = isset($data['template_data']['is_offline']) ?
                       (bool)$data['template_data']['is_offline'] : $this->is_offline;

        $offline_expire_time = isset($data['template_data']['is_offline']) ?
                               (int)$data['template_data']['offline_expire_time'] * 1000 * 3600 :
                               $this->offline_expire_time * 1000 * 3600;

        $network_type = isset($data['template_data']['network_type']) ?
                        (int)$data['template_data']['network_type'] : $this->network_type;

        $getui_template = new GetuiTemplate($this->app, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtListMessage();
        $message->set_isOffline($is_off_line);

        if ($is_off_line) {
            $message->set_offlineExpireTime($offline_expire_time);
        }

        $message->set_pushNetWorkType($network_type);
        $message->set_data($template);

        $contentId = $this->igt->getContentId($message);

        // 接收方列表
        foreach ($data['cid_list'] as $cid) {
            $target = new IGtTarget();
            $target->set_appId($this->app_id);
            $target->set_clientId($cid);
            $target_list[] = $target;
        }

        // 使用队列
        if ($this->queue_is_used) {
            PushGetuiMessage::dispatch($this->igt, 'pushMessageToList', $contentId, $target_list)
                            ->onConnection($this->queue_connection)
                            ->onQueue($this->queue_queue);

            return true;
        }

        $rep = $this->igt->pushMessageToList($contentId, $target_list);

        return $rep;
    }

    /**
     * Push message to specific app.
     *
     * @param $data
     *
     * @return mixed|null
     */
    public function pushMessageToApp($data)
    {
        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];

        $is_off_line = isset($data['template_data']['is_offline']) ?
                       (bool)$data['template_data']['is_offline'] : $this->is_offline;

        $offline_expire_time = isset($data['template_data']['is_offline']) ?
                               (int)$data['template_data']['offline_expire_time'] * 1000 * 3600 :
                               $this->offline_expire_time * 1000 * 3600;

        $network_type = isset($data['template_data']['network_type']) ?
                        (int)$data['template_data']['network_type'] : $this->network_type;

        // todo: need to discuss
        $getui_template = new GetuiTemplate($this->app, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtAppMessage();
        $message->set_isOffline($is_off_line);

        if ($is_off_line) {
            $message->set_offlineExpireTime($offline_expire_time);
        }

        $message->set_pushNetWorkType($network_type);
        $message->set_appIdList(array($this->app_id));
        $message->set_data($template);

        // 使用队列
        if ($this->queue_is_used) {
            PushGetuiMessage::dispatch($this->igt, 'pushMessageToApp', $message)
                            ->onConnection($this->queue_connection)
                            ->onQueue($this->queue_queue);

            return true;
        }

        $rep = $this->igt->pushMessageToApp($message);
        return $rep;
    }
}

