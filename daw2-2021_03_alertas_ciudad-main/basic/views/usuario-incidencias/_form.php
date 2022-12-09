<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-incidencias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'crea_fecha')->textInput() ?>

    <?= $form->field($model, 'clase_incidencia_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'destino_usuario_id')->textInput() ?>

    <?= $form->field($model, 'origen_usuario_id')->textInput() ?>

    <?= $form->field($model, 'alerta_id')->textInput() ?>

    <?= $form->field($model, 'comentario_id')->textInput() ?>

    <?= $form->field($model, 'fecha_lectura')->textInput() ?>

    <?= $form->field($model, 'fecha_borrado')->textInput() ?>

    <?= $form->field($model, 'fecha_aceptado')->textInput() ?>

    <?  //cuando haga la parte `publica, quitar los datos que sean del admin solo ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
