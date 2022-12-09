<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Alertas */

$this->title = 'Create Alertas';
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alertas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
