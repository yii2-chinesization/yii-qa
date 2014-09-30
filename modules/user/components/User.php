<?php
namespace app\modules\user\components;

use Yii;
use yii\db\Expression;

class User extends \yii\web\User
{
    public $loginUrl = ['/user/default/login'];
    public $logoutUrl = ['/user/default/logout'];
    public $registerUrl = ['/user/default/register'];

    /**
     * @inheritdoc
     */
    protected function afterLogin($identity, $cookieBased, $duration)
    {
        $identity = $this->identity;
        $identity->setAttribute('last_visit_at', TIMESTAMP);
//        $identity->setAttribute('last_login_ip', ip2long(Yii::$app->getRequest()->getUserIP()));
        $identity->setAttribute('last_login_ip', Yii::$app->getRequest()->getUserIP());
        $identity->save(false);

        parent::afterLogin($identity, $cookieBased, $duration);
    }
}