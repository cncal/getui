<?php

namespace Cncal\Getui\Sdk;

use Cncal\Getui\Sdk\IGetui\Utils\GTConfig;
use Cncal\Getui\Sdk\IGetui\Utils\ApiUrlRespectUtils;
use Cncal\Getui\Sdk\IGetui\Utils\HttpManager;
use Cncal\Getui\Sdk\IGetui\IGtListMessage;
use Cncal\Getui\Sdk\IGetui\Utils\LangUtils;

Class IGtPush
{
    var $appkey; //第三方 标识
    var $masterSecret; //第三方 密钥
    var $format = "json"; //默认为 json 格式
    var $host = '';
    var $needDetails = false;
    static $appkeyUrlList = array();
    var $domainUrlList = array();
    var $useSSL = NULL; //是否使用https连接 以该标志为准

    public function __construct($domainUrl, $appkey, $masterSecret, $ssl = NULL)
    {
        $this->appkey = $appkey;
        $this->masterSecret = $masterSecret;

        $domainUrl = trim($domainUrl);

        if ($ssl == NULL && $domainUrl != NULL && strpos(strtolower($domainUrl), "https:") === 0) {
            $ssl = true;
        }

        $this->useSSL = ($ssl == NULL ? false : $ssl);

        if ($domainUrl == NULL || strlen($domainUrl) == 0) {
            $this->domainUrlList = GTConfig::getDefaultDomainUrl($this->useSSL);
        } else {
            $this->domainUrlList = array($domainUrl);
        }

        $this->initOSDomain(null);
    }

    private function initOSDomain($hosts)
    {
        if ($hosts == null || count($hosts) == 0) {
            $hosts = isset(self::$appkeyUrlList[$this->appkey]) ? self::$appkeyUrlList[$this->appkey] : null;
            if ($hosts == null || count($hosts) == 0) {
                $hosts = $this->getOSPushDomainUrlList($this->domainUrlList, $this->appkey);
                self::$appkeyUrlList[$this->appkey] = $hosts;
            }
        } else {
            self::$appkeyUrlList[$this->appkey] = $hosts;
        }

        $this->host = ApiUrlRespectUtils::getFastest($this->appkey, $hosts);

        return $this->host;
    }

    public function getOSPushDomainUrlList($domainUrlList, $appkey)
    {
        $urlList = null;
        $postData = array();
        $postData['action'] = 'getOSPushDomailUrlListAction';
        $postData['appkey'] = $appkey;
        $ex = null;
        foreach ($domainUrlList as $durl) {
            try {
                $response = $this->httpPostJSON($durl, $postData);
                $urlList = isset($response["osList"]) ? $response["osList"] : null;
                if ($urlList != null && count($urlList) > 0) {
                    break;
                }
            } catch (\Exception $e) {
                $ex = $e;
            }
        }

        if ($urlList == null || count($urlList) <= 0) {
            $h = implode(',', $domainUrlList);
            throw new \Exception("Can not get hosts from " . $h . "|error:" . $ex);
        }

        return $urlList;
    }

    function httpPostJSON($url, $data, $gzip = false)
    {
        if ($url == null) {
            $url = $this->host;
        }

        $rep = HttpManager::httpPostJson($url, $data, $gzip);

        if ($rep != null) {
            if ('sign_error' == $rep['result']) {
                try {
                    if ($this->connect()) {
                        $rep = HttpManager::httpPostJson($url, $data, $gzip);
                    }
                } catch (\Exception $e) {
                    throw new \Exception("连接异常" . $e);
                }
            } elseif ('domain_error' == $rep['result']) {
                $this->initOSDomain(isset($rep["osList"]) ? $rep["osList"] : null);
                $rep = HttpManager::httpPostJson($url, $data, $gzip);
            }
        }

        return $rep;
    }

    public function connect()
    {
        $timeStamp = $this->micro_time();
        // 计算sign值
        $sign = md5($this->appkey . $timeStamp . $this->masterSecret);
        //
        $params = array();

        $params["action"] = "connect";
        $params["appkey"] = $this->appkey;
        $params["timeStamp"] = $timeStamp;
        $params["sign"] = $sign;
        $rep = HttpManager::httpPostJson($this->host, $params, false);

        if ('success' == $rep['result']) {
            return true;
        }

        throw new \Exception("appKey Or masterSecret is Auth Failed");
    }

    public function close()
    {
        $params = array();
        $params["action"] = "close";
        $params["appkey"] = $this->appKey;
        HttpManager::httpPostJson($this->host, $params, false);
    }

    /**
     *  指定用户推送消息
     * @param  IGtMessage message
     * @param  IGtTarget target
     * @return Array {result:successed_offline,taskId:xxx}  || {result:successed_online,taskId:xxx} || {result:error}
     ***/
    public function pushMessageToSingle($message, $target, $requestId = null)
    {
        if ($requestId == null || trim($requestId) == "") {
            $requestId = uniqid();
        }

        $params = $this->getSingleMessagePostData($message, $target, $requestId);
        return $this->httpPostJSON($this->host, $params);
    }


    function getSingleMessagePostData($message, $target, $requestId = null)
    {
        $params = array();
        $params["action"] = "pushMessageToSingleAction";
        $params["appkey"] = $this->appkey;

        if ($requestId != null) {
            $params["requestId"] = $requestId;
        }

        $params["clientData"] = base64_encode($message->get_data()->get_transparent());
        $params["transmissionContent"] = $message->get_data()->get_transmissionContent();
        $params["isOffline"] = $message->get_isOffline();
        $params["offlineExpireTime"] = $message->get_offlineExpireTime();
        // 增加pushNetWorkType参数(0:不限;1:wifi;2:4G/3G/2G)
        $params["pushNetWorkType"] = $message->get_pushNetWorkType();

        //
        $params["appId"] = $target->get_appId();
        $params["clientId"] = $target->get_clientId();
        $params["alias"] = $target->get_alias();
        // 默认都为消息
        $params["type"] = 2;
        $params["pushType"] = $message->get_data()->get_pushType();
        return $params;
    }

    public function getContentId($message, $taskGroupName = null)
    {
        return $this->getListAppContentId($message, $taskGroupName);
    }

    /**
     *  取消消息
     * @param  String  contentId
     * @return boolean
     ***/
    public function cancelContentId($contentId)
    {
        $params = array();
        $params["action"] = "cancleContentIdAction";
        $params["appkey"] = $this->appKey;
        $params["contentId"] = $contentId;
        $rep = $this->httpPostJSON($this->host, $params);
        return $rep['result'] == 'ok' ? true : false;
    }

    /**
     *  批量推送信息
     * @param  String contentId
     * @param  Array <IGtTarget> targetList
     * @return Array {result:successed_offline,taskId:xxx}  || {result:successed_online,taskId:xxx} || {result:error}
     ***/
    public function pushMessageToList($contentId, $targetList)
    {
        $params = array();
        $params["action"] = "pushMessageToListAction";
        $params["appkey"] = $this->appkey;
        $params["contentId"] = $contentId;
        $needDetails = GTConfig::isPushListNeedDetails();
        $params["needDetails"] = $needDetails;
        $async = GTConfig::isPushListAsync();
        $params["async"] = $async;

        if ($async && (!$needDetails)) {
            $limit = GTConfig::getAsyncListLimit();
        } else {
            $limit = GTConfig::getSyncListLimit();
        }

        if (count($targetList) > $limit) {
            throw new \Exception("target size:" . count($targetList) . " beyond the limit:" . $limit);
        }

        $clientIdList = array();
        $aliasList = array();
        $appId = null;

        foreach ($targetList as $target) {
            $targetCid = $target->get_clientId();
            $targetAlias = $target->get_alias();
            if ($targetCid != null) {
                array_push($clientIdList, $targetCid);
            } elseif ($targetAlias != null) {
                array_push($aliasList, $targetAlias);
            }

            if ($appId == null) {
                $appId = $target->get_appId();
            }
        }
        $params["appId"] = $appId;
        $params["clientIdList"] = $clientIdList;
        $params["aliasList"] = $aliasList;
        $params["type"] = 2;

        return $this->httpPostJSON($this->host, $params, true);
    }

    public function stop($contentId)
    {
        $params = array();
        $params["action"] = "stopTaskAction";
        $params["appkey"] = $this->appkey;
        $params["contentId"] = $contentId;
        $rep = $this->httpPostJSON($this->host, $params);
        if ("ok" == $rep["result"]) {
            return true;
        }

        return false;
    }

    public function getClientIdStatus($appId, $clientId)
    {
        $params = array();
        $params["action"] = "getClientIdStatusAction";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["clientId"] = $clientId;

        return $this->httpPostJSON($this->host, $params);
    }

    public function setClientTag($appId, $clientId, $tags)
    {
        $params = array();
        $params["action"] = "setTagAction";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["clientId"] = $clientId;
        $params["tagList"] = $tags;

        return $this->httpPostJSON($this->host, $params);
    }

    public function pushMessageToApp($message, $taskGroupName = null)
    {
        $contentId = $this->getListAppContentId($message, $taskGroupName);
        $params = array();
        $params["action"] = "pushMessageToAppAction";
        $params["appkey"] = $this->appkey;
        $params["contentId"] = $contentId;
        $params["type"] = 2;

        return $this->httpPostJSON($this->host, $params);
    }

    private function getListAppContentId($message, $taskGroupName = null)
    {
        $params = array();
        if (!is_null($taskGroupName) && trim($taskGroupName) != "") {
            if (strlen($taskGroupName) > 40) {
                throw new \Exception("TaskGroupName is OverLimit 40");
            }
            $params["taskGroupName"] = $taskGroupName;
        }
        $params["action"] = "getContentIdAction";
        $params["appkey"] = $this->appkey;
        $params["clientData"] = base64_encode($message->get_data()->get_transparent());
        $params["transmissionContent"] = $message->get_data()->get_transmissionContent();
        $params["isOffline"] = $message->get_isOffline();
        $params["offlineExpireTime"] = $message->get_offlineExpireTime();
        // 增加pushNetWorkType参数(0:不限;1:wifi;2:4G/3G/2G)
        $params["pushNetWorkType"] = $message->get_pushNetWorkType();
        $params["pushType"] = $message->get_data()->get_pushType();
        $params["type"] = 2;
        //contentType 1是appMessage，2是listMessage
        if ($message instanceof IGtListMessage) {
            $params["contentType"] = 1;
        } else {
            $params["contentType"] = 2;
            $params["appIdList"] = $message->get_appIdList();
            $params["speed"] = $message->get_speed();
            //$params["personaTags"]
            $personaTags = array();
            if ($message->get_conditions() == null) {
                $params["phoneTypeList"] = $message->get_phoneTypeList();
                $params["provinceList"] = $message->get_provinceList();
                $params["tagList"] = $message->get_tagList();
            } else {
                $conditions = $message->get_conditions();
                $params["conditions"] = $conditions->getCondition();
            }
        }

        $rep = $this->httpPostJSON($this->host, $params);

        if ($rep['result'] == 'ok') {
            return $rep['contentId'];
        } else {
            throw new \Exception("host:[" . $this->host . "]" + "获取contentId失败:" . $rep);
        }
    }

    public function getBatch()
    {
        return new IGtBatch($this->appkey, $this);
    }

    public function pushAPNMessageToSingle($appId, $deviceToken, $message)
    {
        $params = array();
        $params['action'] = 'apnPushToSingleAction';
        $params['appId'] = $appId;
        $params['appkey'] = $this->appkey;
        $params['DT'] = $deviceToken;
        $params['PI'] = base64_encode($message->get_data()->get_pushInfo()->SerializeToString());

        return $this->httpPostJSON($this->host, $params);
    }

    /**
     * 根据deviceTokenList群推
     * @param $appId
     * @param $contentId
     * @param $deviceTokenList
     * @return mixed
     */
    public function pushAPNMessageToList($appId, $contentId, $deviceTokenList)
    {
        $params = array();
        $params["action"] = "apnPushToListAction";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["contentId"] = $contentId;
        $params["DTL"] = $deviceTokenList;
        $needDetails = GTConfig::isPushListNeedDetails();
        $params["needDetails"] = $needDetails;

        return $this->httpPostJSON($this->host, $params);
    }

    /**
     * 获取apn contentId
     * @param $appId
     * @param $message
     * @return string
     */
    public function getAPNContentId($appId, $message)
    {
        $params = array();
        $params["action"] = "apnGetContentIdAction";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["PI"] = base64_encode($message->get_data()->get_pushInfo()->SerializeToString());
        $rep = $this->httpPostJSON($this->host, $params);
        if ($rep['result'] == 'ok') {
            return $rep['contentId'];
        } else {
            throw new \Exception("host:[" . $this->host . "]" + "获取contentId失败:" . $rep);
        }
    }

    public function bindAlias($appId, $alias, $clientId)
    {
        $params = array();
        $params["action"] = "alias_bind";
        $params["appkey"] = $this->appkey;
        $params["appid"] = $appId;
        $params["alias"] = $alias;;
        $params["cid"] = $clientId;

        return $this->httpPostJSON($this->host, $params);
    }

    public function bindAliasBatch($appId, $targetList)
    {
        $params = array();
        $aliasList = array();
        foreach ($targetList as $target) {
            $user = array();
            $user["cid"] = $target->get_clientId();
            $user["alias"] = $target->get_alias();
            array_push($aliasList, $user);
        }
        $params["action"] = "alias_bind_list";
        $params["appkey"] = $this->appkey;
        $params["appid"] = $appId;
        $params["aliaslist"] = $aliasList;

        return $this->httpPostJSON($this->host, $params);
    }

    public function queryClientId($appId, $alias)
    {
        $params = array();
        $params["action"] = "alias_query";
        $params["appkey"] = $this->appkey;
        $params["appid"] = $appId;
        $params["alias"] = $alias;

        return $this->httpPostJSON($this->host, $params);
    }

    public function queryAlias($appId, $clientId)
    {
        $params = array();
        $params["action"] = "alias_query";
        $params["appkey"] = $this->appkey;
        $params["appid"] = $appId;
        $params["cid"] = $clientId;

        return $this->httpPostJSON($this->host, $params);
    }

    public function unBindAlias($appId, $alias, $clientId = null)
    {
        $params = array();
        $params["action"] = "alias_unbind";
        $params["appkey"] = $this->appkey;
        $params["appid"] = $appId;
        $params["alias"] = $alias;
        if (!is_null($clientId) && trim($clientId) != "") {
            $params["cid"] = $clientId;
        }

        return $this->httpPostJSON($this->host, $params);
    }

    public function unBindAliasAll($appId, $alias)
    {
        return $this->unBindAlias($appId, $alias);
    }

    public function getPushResult($taskId)
    {
        $params = array();
        $params["action"] = "getPushMsgResult";
        $params["appkey"] = $this->appkey;
        $params["taskId"] = $taskId;

        return $this->httpPostJson($this->host, $params);
    }

    public function getPushResultByTaskidList($taskIdList)
    {
        return $this->getPushActionResultByTaskids($taskIdList, null);
    }

    public function getPushActionResultByTaskids($taskIdList, $actionIdList)
    {
        $params = array();
        $params["action"] = "getPushMsgResultByTaskidList";
        $params["appkey"] = $this->appkey;
        $params["taskIdList"] = $taskIdList;
        $params["actionIdList"] = $actionIdList;

        return $this->httpPostJson($this->host, $params);
    }

    public function getUserTags($appId, $clientId)
    {
        $params = array();
        $params["action"] = "getUserTags";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["clientId"] = $clientId;

        return $this->httpPostJson($this->host, $params);
    }

    public function getUserCountByTags($appId, $tagList)
    {
        $params = array();
        $params["action"] = "getUserCountByTags";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["tagList"] = $tagList;
        $limit = GTConfig::getTagListLimit();
        if (count($tagList) > $limit) {
            throw new \Exception("tagList size:" . count($tagList) . " beyond the limit:" . $limit);
        }

        return $this->httpPostJSON($this->host, $params);
    }

    public function getPersonaTags($appId)
    {
        $params = array();
        $params["action"] = "getPersonaTags";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;

        return $this->httpPostJSON($this->host, $params);
    }

    public function queryAppPushDataByDate($appId, $date)
    {
        if (!LangUtils::validateDate($date)) {
            throw new \Exception("DateError|" . $date);
        }
        $params = array();
        $params["action"] = "queryAppPushData";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["date"] = $date;

        return $this->httpPostJson($this->host, $params);
    }

    public function queryAppUserDataByDate($appId, $date)
    {
        if (!LangUtils::validateDate($date)) {
            throw new \Exception("DateError|" . $date);
        }

        $params = array();
        $params["action"] = "queryAppUserData";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        $params["date"] = $date;

        return $this->httpPostJson($this->host, $params);
    }

    public function queryUserCount($appId, $appConditions)
    {
        $params = array();
        $params["action"] = "queryUserCount";
        $params["appkey"] = $this->appkey;
        $params["appId"] = $appId;
        if (!is_null($appConditions)) {
            $params["conditions"] = $appConditions->condition;
        }

        return $this->httpPostJson($this->host, $params);
    }

    private function micro_time()
    {
        list($usec, $sec) = explode(" ", microtime());
        $time = ($sec . substr($usec, 2, 3));
        return $time;
    }
}
