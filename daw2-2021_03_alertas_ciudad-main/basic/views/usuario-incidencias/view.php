<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencias */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usuario Incidencias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-incidencias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) //botón de update ?>  
        <?= Html::a('Answer', ['answer', 'id' => $model->id], ['class' => 'btn btn-primary']) //botón de responder la incidencia ?>  
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
            'crea_fecha',
            'clase_incidencia_id',
            'texto:ntext',
            'destino_usuario_id',
            'origen_usuario_id',
            'alerta_id',
            'comentario_id',
            'fecha_lectura',
            'fecha_borrado',
            'fecha_aceptado',
        ],
    ]) ?>

</div>
