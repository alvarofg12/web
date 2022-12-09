<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Areas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="areas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'clase_area_id')->dropDownList($model->clase_area(), array('options' => array('1'=>array('selected'=>true))))  ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'area_id')->hiddenInput(['readonly' => true, 'value' => $model->isNewRecord ? (isset($area_id)? $area_id : 0) : $model->area_id])->label(false) ?>

    <?= $form->field($model, 'area_padre')->textInput(['readonly' => true, 'value' => $padre]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
