<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Alertas */

$this->title = $model->titulo;
\yii\web\YiiAsset::register($this);
?>
<div class="alertas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= Html::a('Volver', ['site/alertas'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            'duracion_estimada',
            'direccion:ntext',
            'notas_lugar:ntext',
            'detalles:ntext',
            'notas:ntext',
            'url:ntext',
            'num_denuncias',
        ],
    ]) ?>

</div>
