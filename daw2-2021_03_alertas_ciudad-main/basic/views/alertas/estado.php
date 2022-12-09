<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Alertas */

$this->title = 'Estado de la alerta';
\yii\web\YiiAsset::register($this);
?>
<div class="alertas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            //'duracion_estimada',
            //'direccion:ntext',
            //'notas_lugar:ntext',
            //'area_id',
            //'detalles:ntext',
            //'notas:ntext',
            //'url:ntext',
            //'imagen_id',
            //'imagen_revisada',
            //'categoria_id',
            'activada',
            /*'visible',
            'terminada',
            'fecha_terminacion',
            'notas_terminacion:ntext',
            */'num_denuncias',/*
            'fecha_denuncia1',
            'bloqueada',
            'bloqueo_usuario_id',
            'bloqueo_fecha',
            'bloqueo_notas:ntext',
            'crea_usuario_id',
            'crea_fecha',
            'modi_usuario_id',
            'modi_fecha',
            'notas_admin:ntext',*/
        ],
    ]) ?>

    <?= Html::a('Volver', ['site/alertas'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Denunciar', ['denuncia','id'=>$model->id], ['class' => 'btn btn-danger']) ?>


</div>
