<?php
use yii\helpers\Html;
?>
<?php if ($header !== false): ?>
    <div class="modal-header">
        <?php if ($header === null): ?>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <?= Html::encode($this->title) ?>
        <?php else: ?>
            <?= $header ?>
        <?php endif ?>
    </div>
<?php endif ?>
    <div class="modal-body">
        <?= $content ?>
    </div>
<?php if ($footer !== false): ?>
    <div class="modal-footer">
        <?= $footer ?>
    </div>
<?php endif ?>