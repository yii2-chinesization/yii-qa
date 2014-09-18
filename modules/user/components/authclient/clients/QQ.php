<?php
namespace app\modules\user\components\authclient\clients;

use yii\authclient\OAuth2;

class QQ extends OAuth2
{
    /**
     * @inheritdoc
     */
    public $authUrl = 'https://graph.qq.com/oauth2.0/authorize';
    /**
     * @inheritdoc
     */
    public $tokenUrl = 'https://graph.qq.com/oauth2.0/token';
    /**
     * @inheritdoc
     */
    public $apiBaseUrl = 'https://graph.qq.com';

    public $format = 'json';

    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        return $this->api('user/get_user_info.' . $this->format, 'GET');
    }

    /**
     * @inheritdoc
     */
    protected function defaultName()
    {
        return 'qq';
    }

    /**
     * @inheritdoc
     */
    protected function defaultTitle()
    {
        return '腾讯QQ';
    }
}