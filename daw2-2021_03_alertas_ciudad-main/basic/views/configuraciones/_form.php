<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuraciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'variable')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
