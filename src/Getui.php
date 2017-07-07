<?php
namespace Cncal\Getui;

use Illuminate\Config\Repository;
use Cncal\Getui\Sdk\IGtPush;
use Cncal\Getui\Sdk\IGetui\IGtAppMessage;
use Cncal\Getui\Sdk\IGetui\IGtSingleMessage;
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
        $host = $config['basic_info']['host'];
        $app_id = $config['basic_info']['app_id'];
        $app_key = $config['basic_info']['app_key'];
        $master_secret = $config['basic_info']['master_secret'];

        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];
        $cid = $data['cid'];

        $is_off_line = $config['push_info']['is_offline'];
        $offline_expire_time = $config['push_info']['offline_expire_time'];
        $push_network_type = $config['push_info']['network_type'];

        $igt = new IGtPush($host, $app_key, $master_secret);

        //todo: need to discuss
        $getui_template = new GetuiTemplate($app_id, $app_key, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtSingleMessage();
        $message->set_isOffline($is_off_line);
        $message->set_offlineExpireTime($offline_expire_time);
        $message->set_pushNetWorkType($push_network_type);
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
        $host = $config['basic_info']['host'];
        $app_id = $config['basic_info']['app_id'];
        $app_key = $config['basic_info']['app_key'];
        $master_secret = $config['basic_info']['master_secret'];

        // 解析数据
        $template_type = $data['template_type'];
        $template_data = $data['template_data'];

        $is_off_line = $config['push_info']['is_offline'];
        $offline_expire_time = $config['push_info']['offline_expire_time'];
        $push_network_type = $config['push_info']['network_type'];

        $igt = new IGtPush($host, $app_key, $master_secret);

        // todo: need to discuss
        $getui_template = new GetuiTemplate($app_id, $app_key, $template_type, $template_data);
        $template = $getui_template->getTemplate();

        $message = new IGtAppMessage();
        $message->set_isOffline($is_off_line);
        $message->set_offlineExpireTime($offline_expire_time);
        $message->set_pushNetWorkType($push_network_type);
        $message->set_appIdList(array($app_id));
        $message->set_data($template);

        $rep = $igt->pushMessageToApp($message);
        return $rep;
    }
}

