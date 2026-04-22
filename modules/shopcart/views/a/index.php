<?php
use yii\cherryii\modules\shopcart\models\News;
use yii\cherryii\modules\shopcart\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('cherryii/shopcart', 'Orders');

$module = $this->context->module->id;
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>
    <table class="table table-hover">
        <thead>
            <tr>
                <th width="100">#</th>
                <th><?= Yii::t('cherryii', 'Name') ?></th>
                <th><?= Yii::t('cherryii/shopcart', 'Address') ?></th>
                <th width="100"><?= Yii::t('cherryii/shopcart', 'Cost') ?></th>
                <th width="150"><?= Yii::t('cherryii', 'Date') ?></th>
                <th width="90"><?= Yii::t('cherryii', 'Status') ?></th>
                <th width="90"></th>
            </tr>
        </thead>
        <tbody>
    <?php foreach($data->models as $item) : ?>
            <tr>
                <td>
                    <?= Html::a($item->primaryKey, ['/admin/shopcart/a/view', 'id' => $item->primaryKey]) ?>
                    <?php if($item->new) : ?>
                        <span class="label label-warning">NEW</span>
                    <?php endif; ?>
                </td>
                <td><?= $item->name ?></td>
                <td><?= $item->address ?></td>
                <td><?= $item->cost ?></td>
                <td><?= Yii::$app->formatter->asDatetime($item->time, 'short') ?></td>
                <td><?= Order::statusName($item->status) ?></td>
                <td class="control">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?= Url::to(['/admin/'.$module.'/a/view', 'id' => $item->primaryKey]) ?>" class="btn btn-default" title="<?= Yii::t('cherryii/shopcart', 'View') ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                        <a href="<?= Url::to(['/admin/'.$module.'/a/delete', 'id' => $item->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('cherryii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </td>
            </tr>
    <?php endforeach; ?>
        </tbody>
    </table>
    <?= yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ]) ?>
<?php else : ?>
    <p><?= Yii::t('cherryii', 'No records found') ?></p>
<?php endif; ?>