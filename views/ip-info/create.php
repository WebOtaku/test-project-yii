<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\IpInfo $model */

$this->title = 'Добавление IP';
$this->params['breadcrumbs'][] = ['label' => 'Список IP адресов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ip-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form-add.twig', [
        'model' => $model,
    ]) ?>

</div>
