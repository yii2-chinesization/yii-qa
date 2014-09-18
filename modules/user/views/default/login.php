<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\AjaxModal;
use app\modules\user\assets\UserAsset;

$isLogin = isset($loginForm);

$this->title = $isLogin ? '登录' : '注册';
$this->params['header'] = false;
UserAsset::register($this);
$user = Yii::$app->getUser();
AjaxModal::begin();
?>
<div class="login">
    <?php $form = ActiveForm::begin() ?>
        <div class="row">
        <?php if ($isLogin): ?>
            <div class="col-sm-6">
                <a class="btn btn-block btn-primary" href="#">使用QQ账号登录</a>
                <a class="btn btn-block btn-info" href="#">使用微博账号登录</a>
                <a class="btn btn-block btn-warning" href="#">使用人人账号登录</a>
            </div>
            <div class="col-sm-6">
                <?= $form->field($loginForm, 'username')->textInput([
                    'placeholder' => $loginForm->getAttributeLabel('username'),
                ]) ?>
                <?= $form->field($loginForm, 'password')->passwordInput([
                    'placeholder' => $loginForm->getAttributeLabel('password'),
                ]) ?>
                <?= $form->field($loginForm, 'rememberMe', [
                    'template' => Html::a('忘记密码?', ['/user/default/resetPassword'], ['class' => 'pull-right']) . "\n{input}"
                ])->checkbox() ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-block btn-primary']) ?>
            </div>
        <?php else: ?>
            <div class="col-sm-6">
                <a class="btn btn-block btn-primary" href="#">使用QQ账号注册</a>
                <a class="btn btn-block btn-info" href="#">使用微博账号注册</a>
                <a class="btn btn-block btn-warning" href="#">使用人人账号注册</a>
            </div>
            <div class="col-sm-6">
                <?= $form->field($registerForm, 'username')->textInput([
                    'placeholder' => $registerForm->getAttributeLabel('username'),
                ]) ?>
                <?= $form->field($registerForm, 'email')->textInput([
                    'placeholder' => $registerForm->getAttributeLabel('email') . ':'
                ]) ?>
                <?= $form->field($registerForm, 'password')->passwordInput([
                    'placeholder' => $registerForm->getAttributeLabel('password') . ':'
                ]) ?>
                <?= Html::submitButton('注册', ['class' => 'btn btn-block btn-primary']) ?>
            </div>
        <?php endif ?>
        </div>
    <?php ActiveForm::end() ?>
</div>
<?php
AjaxModal::end();
