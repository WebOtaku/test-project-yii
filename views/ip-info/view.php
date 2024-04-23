<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\IpInfo $model */

$this->title = $model->ip;
$this->params['breadcrumbs'][] = ['label' => 'Список IP адресов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ip-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ip' => $model->ip], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ip' => $model->ip], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ip',
            'country',
            'region',
            'city',
        ],
    ]) ?>

</div>
