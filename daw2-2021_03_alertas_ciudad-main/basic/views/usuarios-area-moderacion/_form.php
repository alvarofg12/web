<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosAreaModeracion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-area-moderacion-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'usuario_id')->dropDownList($usuarios)->label('Elige el usuario') ?>

    <?= $form->field($model, 'area_id')->dropDownList($areas)->label('Elige el area') ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
