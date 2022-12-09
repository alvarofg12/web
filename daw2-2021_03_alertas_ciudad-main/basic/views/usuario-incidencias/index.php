<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioIncidenciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuario Incidencias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-incidencias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Incidencia de Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'crea_fecha',
            'clase_incidencia_id',
            'texto:ntext',
            'destino_usuario_id',
            'origen_usuario_id',
            //'alerta_id',
            //'comentario_id',
            //'fecha_lectura',
            //'fecha_borrado',
            //'fecha_aceptado',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
