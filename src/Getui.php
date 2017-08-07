<?php
namespace Cncal\Getui;

use Illuminate\Config\Repository;
use Cncal\Getui\Sdk\IGtPush;
use Cncal\Getui\Sdk\IGetui\IGtAppMessage;
use Cncal\Getui\Sdk\IGetui\IGtSingleMessage;
use Cncal\Getui\Sdk\IGetui\IGtListMessage;
use Cncal\Getui\Sdk\IGetui\Template\GetuiTemplate;
use Cncal\Getui\Sdk\IGetui\IGtTarget;
use Cncal\Getui\Sdk\Exception\GetuiException;

class Getui
{
    /**
     * @var Repository
     */
    protected $config;

    /**
     * Getui constructor.
     *
     * @param \Illuminate\Config\Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Push message to single user.
     *
     * @param $data
     *
     * @return Sdk\Array
     */
    public function pushMessageToSingle($data)
    {
        // 获取个推配置信息
        $config = $this->config->get('getui');
        $host = $config['basic']['host'];
        $app_id = $config['basic']['app_id'];
        $app_key = $config['basic']['app_key'];
        $master_secret = $config['basic']['master_secret'];

        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];
        $cid = $data['cid'];

        $is_off_line = isset($data['template_data']['is_offline']) ?
            (bool)$data['template_data']['is_offline'] : $config['push']['is_offline'];

        $offline_expire_time = isset($data['template_data']['is_offline']) ?
            (int)$data['template_data']['offline_expire_time'] * 1000 * 3600 :
            $config['push']['offline_expire_time'] * 1000 * 3600;

        $network_type = isset($data['template_data']['network_type']) ?
            (int)$data['template_data']['network_type'] : $config['push']['network_type'];

        $igt = new IGtPush($host, $app_key, $master_secret);

        //todo: need to discuss
        $getui_template = new GetuiTemplate($app_id, $app_key, $config, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtSingleMessage();
        $message->set_isOffline($is_off_line);
        if($is_off_line)
        {
            $message->set_offlineExpireTime($offline_expire_time);
        }
        $message->set_pushNetWorkType($network_type);
        $message->set_data($template);

        // 接收方
        $target = new IGtTarget();
        $target->set_appId($app_id);
        $target->set_clientId($cid);

        try {
            $rep = $igt->pushMessageToSingle($message, $target);
        } catch(GetuiException $e) {
            $requestId = $e->getRequestId();
            $rep = $igt->pushMessageToSingle($message, $target, $requestId);
        }

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
        // 获取个推配置信息
        $config = $this->config->get('getui');
        $host = $config['basic']['host'];
        $app_id = $config['basic']['app_id'];
        $app_key = $config['basic']['app_key'];
        $master_secret = $config['basic']['master_secret'];

        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];

        $is_off_line = isset($data['template_data']['is_offline']) ?
            (bool)$data['template_data']['is_offline'] : $config['push']['is_offline'];

        $offline_expire_time = isset($data['template_data']['is_offline']) ?
            (int)$data['template_data']['offline_expire_time'] * 1000 * 3600 :
            $config['push']['offline_expire_time'] * 1000 * 3600;

        $network_type = isset($data['template_data']['network_type']) ?
            (int)$data['template_data']['network_type'] : $config['push']['network_type'];

        $igt = new IGtPush($host, $app_key, $master_secret);

        $getui_template = new GetuiTemplate($app_id, $app_key, $config, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtListMessage();
        $message->set_isOffline($is_off_line);
        if($is_off_line)
        {
            $message->set_offlineExpireTime($offline_expire_time);
        }
        $message->set_pushNetWorkType($network_type);
        $message->set_data($template);

        $contentId = $igt->getContentId($message);

        // 接收方列表
        foreach ($data['cid_list'] as $cid)
        {
            $target = new IGtTarget();
            $target->set_appId($app_id);
            $target->set_clientId($cid);
            $target_list[] = $target;
        }

        $rep = $igt->pushMessageToList($contentId, $target_list);

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
        // 获取个推配置信息
        $config = $this->config->get('getui');
        $host = $config['basic']['host'];
        $app_id = $config['basic']['app_id'];
        $app_key = $config['basic']['app_key'];
        $master_secret = $config['basic']['master_secret'];

        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];

        $is_off_line = isset($data['template_data']['is_offline']) ?
            (bool)$data['template_data']['is_offline'] : $config['push']['is_offline'];


        $offline_expire_time = isset($data['template_data']['is_offline']) ?
            (int)$data['template_data']['offline_expire_time'] * 1000 * 3600 :
            $config['push']['offline_expire_time'] * 1000 * 3600;


        $network_type = isset($data['template_data']['network_type']) ?
            (int)$data['template_data']['network_type'] : $config['push']['network_type'];

        $igt = new IGtPush($host, $app_key, $master_secret);

        // todo: need to discuss
        $getui_template = new GetuiTemplate($app_id, $app_key, $config, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtAppMessage();
        $message->set_isOffline($is_off_line);
        if($is_off_line)
        {
            $message->set_offlineExpireTime($offline_expire_time);
        }
        $message->set_pushNetWorkType($network_type);
        $message->set_appIdList(array($app_id));
        $message->set_data($template);

        $rep = $igt->pushMessageToApp($message);
        return $rep;
    }
}

