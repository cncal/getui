<?php
namespace Cncal\Getui\Sdk\IGetui\Template;

use Cncal\Getui\Sdk\IGetui\IGtAPNPayload;
use Cncal\Getui\Sdk\IGetui\Msg\DictionaryAlertMsg;

class GetuiTemplate
{
    /**
     * @var string
     */
    protected $app_id;

    /**
     * @var string
     */
    protected $app_key;

    /**
     * Template type.
     *
     * @var integer
     */
    protected $type;

    /**
     * The params that template requires.
     *
     * @var mixed
     */
    protected $template_data;

    /**
     * GetuiTemplate constructor.
     *
     * @param $app_id
     * @param $app_key
     * @param $type
     * @param $template_data
     */
    public function __construct($app_id, $app_key, $type, $template_data)
    {
        $this->app_id = $app_id;
        $this->app_key = $app_key;
        $this->type = $type;
        $this->template_data = $template_data;
    }

    public function getTemplate()
    {
        switch ($this->type)
        {
            case 1:
                $template = $this->IGtNotificationTemplateDemo();
                break;
            case 2:
                $template = $this->IGtLinkTemplateDemo();
                break;
            case 3:
                $template = $this->IGtNotyPopLoadTemplateDemo();
                break;
            case 4:
                $template = $this->IGtTransmissionTemplate();
                break;
            default:
                $template = '';
        }
        return $template;
    }

    /**
     * 点击通知打开应用模板
     */
    private function IGtNotificationTemplateDemo()
    {
        // 解析模板数据
        extract($this->template_data);

        $template =  new IGtNotificationTemplate();
        $template->set_appId($this->app_id);
        $template->set_appkey($this->app_key);
        $template->set_transmissionType((int)$transmission_type);
        $template->set_transmissionContent($transmission_content);
        $template->set_title($title);
        $template->set_text($text);
        $template->set_isRing(isset($is_ring) ? (boolean)$is_ring : 'GT_ON');
        $template->set_isVibrate(isset($is_vibrate) ? (boolean)$is_vibrate : 'GT_ON');
        $template->set_isClearable(isset($is_clearable) ? (boolean)$is_clearable : 'GT_ON');

        if(isset($begin_time) && isset($end_time))
        {
            $template->set_duration(date_format($begin_time, 'Y-m-d H:i:s'), date_format($end_time, 'Y-m-d H:i:s'));
        }

        return $template;
    }

    /**
     * 点击通知打开网页模板
     */
    private function IGtLinkTemplateDemo()
    {
        // 解析模板数据
        extract($this->template_data);

        $template =  new IGtLinkTemplate();
        $template->set_appId($this->app_id);
        $template->set_appkey($this->app_key);
        $template->set_title($title);
        $template->set_text($text);
        $template->set_url($url);
        $template->set_isRing(isset($is_ring) ? (boolean)$is_ring : true);
        $template->set_isVibrate(isset($is_vibrate) ? (boolean)$is_vibrate : true);
        $template->set_isClearable(isset($is_clearable) ? (boolean)$is_clearable : true);

        if(isset($begin_time) && isset($end_time))
        {
            $template->set_duration(date_format($begin_time, 'Y-m-d H:i:s'), date_format($end_time, 'Y-m-d H:i:s'));
        }

        return $template;
    }

    /**
     * 点击通知弹窗下载模板
     */
    private function IGtNotyPopLoadTemplateDemo()
    {
        // 解析模板数据
        extract($this->template_data);

        $template =  new IGtNotyPopLoadTemplate();
        $template->set_appId($this->app_id);
        $template->set_appkey($this->app_key);

        // 通知栏
        $template->set_notyTitle($title);
        $template->set_notyContent($text);
        $template->set_isBelled(isset($is_ring) ? (boolean)$is_ring : true);
        $template->set_isVibrationed(isset($is_vibrate) ? (boolean)$is_vibrate : true);
        $template->set_isCleared(isset($is_clearable) ? (boolean)$is_clearable : true);

        // 弹框
        $template->set_popTitle($pop_title);
        $template->set_popContent($pop_content);
        $template->set_popImage($pop_image);
        $template->set_popButton1($pop_button_left);
        $template->set_popButton2($pop_button_right);

        // 下载
        $template->set_loadIcon($load_icon);
        $template->set_loadTitle($load_title);
        $template->set_loadUrl("$load_url");
        $template->set_isAutoInstall(isset($is_auto_install) ? (boolean)$is_auto_install : false);
        $template->set_isActived(isset($is_actived) ? (boolean)$is_actived : false);

        if(isset($begin_time) && isset($end_time))
        {
            $template->set_duration(date_format($begin_time, 'Y-m-d H:i:s'), date_format($end_time, 'Y-m-d H:i:s'));
        }

        return $template;
    }

    /**
     * 透传消息模版
     */
    private function IGtTransmissionTemplate()
    {
        $template =  new IGtTransmissionTemplate();
        $template->set_appId($this->app_id);
        $template->set_appkey($this->app_key);
        $template->set_transmissionType(1);   // 收到消息是否立即启动应用，1为立即启动，2则广播等待客户端自启动
        $template->set_transmissionContent("测试离线ddd");   // 透传内容，不支持转义字符

        // APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg = new DictionaryAlertMsg();
        $alertmsg->body = "body";
        $alertmsg->actionLocKey = "ActionLockey";
        $alertmsg->locKey = "LocKey";
        $alertmsg->locArgs = array("locargs");
        $alertmsg->launchImage = "launchimage";

        // IOS8.2 支持
        $alertmsg->title = "Title";
        $alertmsg->titleLocKey = "TitleLocKey";
        $alertmsg->titleLocArgs = array("TitleLocArg");

        $apn->alertMsg = $alertmsg;
        $apn->badge = 7;   // 应用icon上显示的数字
        $apn->sound = "";   // 通知铃声文件名
        $apn->add_customMsg("payload","payload");  // 增加自定义的数据
        $apn->contentAvailable = 1;
        $apn->category = "ACTIONABLE";  // 在客户端通知栏触发特定的action和button显示
        $template->set_apnInfo($apn);

        return $template;
    }
}