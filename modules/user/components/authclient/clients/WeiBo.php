<?php
namespace app\modules\user\components\authclient\clients;

use yii\authclient\OAuth2;

class WeiBo extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://api.weibo.com/oauth2/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://api.weibo.com/oauth2/access_token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://api.weibo.com/2';

    public $format = 'json';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->api('account/get_uid.' . $this->format, 'GET');
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'weibo';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return '新浪微博';
    }
}