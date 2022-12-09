<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alerta Comentarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="alerta-comentarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'alerta_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=alertas%2Fview&id='.$model->alerta_id.'">'.$model->alerta_id.'</a>';}],
            ['attribute' => 'crea_usuario_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->crea_usuario_id.'">'.$model->crea_usuario_id.'</a>';}],
            'crea_fecha',
            ['attribute' => 'modi_usuario_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->modi_usuario_id.'">'.$model->modi_usuario_id.'</a>';}],
            'modi_fecha',
            'texto:ntext',
            ['attribute' => 'comentario_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=alerta-comentario%2Fview&id='.$model->comentario_id.'">'.$model->comentario_id.'</a>';}],
            'cerrado',
            'num_denuncias',
            'fecha_denuncia1',
            'bloqueado',
            'bloqueo_usuario_id',
            'bloqueo_fecha',
            'bloqueo_notas:ntext',
        ],
    ]) ?>

</div>
