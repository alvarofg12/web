<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagenes */

$this->title = 'Update Alerta Imagenes: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alerta Imagenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="alerta-imagenes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
