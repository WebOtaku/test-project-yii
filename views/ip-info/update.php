<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\IpInfo $model */

$this->title = 'Обновление информации об IP: ' . $model->ip;
$this->params['breadcrumbs'][] = ['label' => 'Список IP адресов', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ip, 'url' => ['view', 'ip' => $model->ip]];
$this->params['breadcrumbs'][] = 'Обновление';
var_dump($this->params);
?>
<div class="ip-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-update.twig', [
        'model' => $model,
    ]) ?>

</div>
