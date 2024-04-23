<?php

use app\models\IpInfo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use app\widgets\CustomGridView;
use yii\grid\SerialColumn;

/** @var yii\web\View $this */
/** @var app\models\IpInfoSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Список IP адресов';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ip-info-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Добавить IP', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= CustomGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'ip',
            'country',
            'region',
            'city',
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, IpInfo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'ip' => $model->ip]);
                }
            ],
        ],
    ]); ?>
</div>