<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaImagenes */

$this->title = 'Create Alerta Imagenes';
$this->params['breadcrumbs'][] = ['label' => 'Alerta Imagenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagenes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
