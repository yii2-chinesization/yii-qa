<?php
$storageCollection = Yii::$app->get('storageCollection');
$storageCollection->getStorage('qiniu')->registerUploadJs([
    'uploadSettings' => [
        'autoUpload' => true
    ],
]);
?>
<div class="container" data-toggle="upload">
    <input type="file" name="file" multiple />
    <input type="submit" name="submit" value="提交" />
</div>