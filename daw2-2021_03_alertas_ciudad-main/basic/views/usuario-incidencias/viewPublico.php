<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencias */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-incidencias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'crea_fecha',
            //'clase_incidencia_id',
            'texto:ntext',
            //'destino_usuario_id',
            //'origen_usuario_id',
            //'alerta_id',
            'comentario_id',
            //'fecha_lectura',
            //'fecha_borrado',
            //'fecha_aceptado',
        ],
    ]) ?>

</div>
