<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Alertas */
//prueva
echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">';

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Alertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="alertas-view">

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
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            'duracion_estimada',
            'direccion:ntext',
            'notas_lugar:ntext',
            ['attribute' => 'area_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=areas%2Fview&id='.$model->area_id.'">'.$model->area_id.'</a>';}],

            'detalles:ntext',
            'notas:ntext',
            'url:ntext',
            ['attribute' => 'imagen_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=alerta-imagenes%2Fview&id='.$model->imagen_id.'">'.$model->imagen_id.'</a>';}],

            'imagen_revisada',
            ['attribute' => 'categoria_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=categorias%2Fview&id='.$model->categoria_id.'">'.$model->categoria_id.'</a>';}],

            'activada',
            'visible',
            'terminada',
            'fecha_terminacion',
            'notas_terminacion:ntext',
            'num_denuncias',
            'fecha_denuncia1',
            'bloqueada',
            'bloqueo_usuario_id',
            'bloqueo_fecha',
            'bloqueo_notas:ntext',
            ['attribute' => 'crea_usuario_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->crea_usuario_id.'">'.$model->crea_usuario_id.'</a>';}],

            'crea_fecha',
            ['attribute' => 'modi_usuario_id',
            'format' => 'raw',
            'value' => function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->modi_usuario_id.'">'.$model->modi_usuario_id.'</a>';}],

            'modi_fecha',
            'notas_admin:ntext',

            [ 'label' => 'comentarios',
            'format' => 'raw',
            'value'=>function ($model) {
                    return Html::a('<span class="material-icons md-light md-inactive">chat</span>', 'index.php?AlertaComentariosSearch[alerta_id]='.$model->id.'&r=alerta-comentarios%2Findex',['class' => 'glyphicon glyphicon-plus btn btn-default btn-xs custom_button']);
                }
            ],
        ],
    ]) ?>

</div>
