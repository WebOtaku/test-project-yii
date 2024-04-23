<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\IpInfo $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ip-info-form">

    <?php $form = ActiveForm::begin(); ?>
    <!-- ['action'=> Url::to(['ip-info/create'])] -->

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>