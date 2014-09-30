<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\user\assets\UserAsset;
UserAsset::register($this);

$identity = Yii::$app->getUser()->getIdentity();
$this->title = $identity->username;
?>
<div class="container-fluid">
    <h3><?= Html::encode($identity->username) ?> <small>@<?= Html::encode($identity->username) ?></small></h3>
    <div class="user-profile">
        <div class="user-avatar">
            <?= Html::img($identity->getAvatarUrl(), ['class' => 'avatar-xl']) ?>
        </div>
        <div class="user-info">

        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <span class="thumbnail">
                <?= Html::img($identity->getAvatarUrl()) ?>
            </span>
        </div>
        <div class="col-sm-9">
            <span class="thumbnail">
                <?= Html::img($identity->getAvatarUrl()) ?>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-3">
            <div id="userAvatar">
                <div class="thumbnail">
                    <?= Html::img($identity->getAvatarUrl()) ?>
                </div>
                <div class="file-input text-center">
                    <span class="avatar-upload-text"> 点击修改头像 </span>
                    <input type="file" name="file">
                </div>
            </div>
            <div id="userInfo" class="clearfix">
                <a href="javascript:;"><strong><?= $identity->following ?></strong> 关注</a>
                <a href="javascript:;"><strong><?= $identity->followers ?></strong> 粉丝</a>
                <a href="javascript:;"><strong><?= $identity->photos ?></strong> 图片</a>
            </div>
            <ul id="userProfile" class="list-unstyled">
                <li>
                    <span class="glyphicon glyphicon-envelope"></span>
                    <a href="mailto:<?= $identity->email ?>"> <?= $identity->email ?> </a>
                </li>
                <li>
                    <span class="glyphicon glyphicon-time"></span>
                    <?php $time = date("Y-m-d H:i:s", $identity->created_at) ?>
                    <time title="<?= $time ?>"><?= $time ?></time>
                </li>
            </ul>
        </div>
        <div class="col-lg-10 col-md-9">

        </div>
    </div>
</div>