<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alerta-comentarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'alerta_id')->textInput() ?>

    <?= $form->field($model, 'crea_usuario_id')->textInput() ?>

    <?= $form->field($model, 'crea_fecha')->textInput() ?>

    <?= $form->field($model, 'modi_usuario_id')->textInput() ?>

    <?= $form->field($model, 'modi_fecha')->textInput() ?>

    <?= $form->field($model, 'texto')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comentario_id')->textInput() ?>

    <?= $form->field($model, 'cerrado')->textInput() ?>

    <?= $form->field($model, 'num_denuncias')->textInput() ?>

    <?= $form->field($model, 'fecha_denuncia1')->textInput() ?>

    <?= $form->field($model, 'bloqueado')->textInput() ?>

    <?= $form->field($model, 'bloqueo_usuario_id')->textInput() ?>

    <?= $form->field($model, 'bloqueo_fecha')->textInput() ?>

    <?= $form->field($model, 'bloqueo_notas')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
