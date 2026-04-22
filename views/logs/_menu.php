<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-pills">
    <li <?= ($action==='index') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/logs']) ?>"><?= Yii::t('cherryii', 'Sign in') ?></a></li>
</ul>
<br/>
