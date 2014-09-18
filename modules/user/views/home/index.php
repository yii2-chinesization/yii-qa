<?php
use yii\helpers\Html;
use yii\helpers\Url;

$identity = Yii::$app->getUser()->getIdentity();
$this->title = $identity->username;
$this->registerCssFile('@web/css/user.css', 'app\assets\AppAsset');
?>
<div class="container-fluid pt25">
    <div class="row">
        <div class="col-lg-2 col-md-3 col-sm-3">
            <div id="userAvatar">
                <div class="thumbnail">
                    <?= Html::img($identity->getDefaultAvatarUrl()) ?>
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
            <div id="userAlbums" class="clearfix">
                <?php foreach ($identity->albums as $aid => $album): ?>
                    <dl class="thumbnail">
                        <dt class="clearfix">
                            <?php foreach ($album->getPictures()->limit(9)->each() as $picture): ?>
                                <a href="javascript:;"><img class="img-rounded" src="<?= $picture->getUrl() ?>"/></a>
                            <?php endforeach ?>
                        </dt>
                        <dd class="caption">
                            <h4 class="text-center"><?= Html::encode($album->name) ?></h4>

                            <p><?= Html::encode($album->description) ?></p>

                            <div class="clearfix text-muted">
                                <small class="pull-left">
                                    <span>10张图片</span>
                                </small>
                                <small class="pull-right">
                                    <span>10人觉得赞</span>
                                    <span>5个评论</span>
                                </small>
                            </div>
                        </dd>
                    </dl>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>