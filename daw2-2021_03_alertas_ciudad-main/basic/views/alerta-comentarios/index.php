<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaComentariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alerta Comentarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-comentarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Alerta Comentarios', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['class' => 'yii\grid\DataColumn','attribute' => 'alerta_id','content'=>function ($model){return '<a href="index.php?r=alertas%2Fview&id='.$model->alerta_id.'">'.$model->alerta_id.'</a>';}],
            ['class' => 'yii\grid\DataColumn','attribute' => 'crea_usuario_id','content'=>function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->crea_usuario_id.'">'.$model->crea_usuario_id.'</a>';}],
            'crea_fecha',
            'crea_fecha',
            ['class' => 'yii\grid\DataColumn','attribute' => 'modi_usuario_id','content'=>function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->modi_usuario_id.'">'.$model->modi_usuario_id.'</a>';}],
            //'modi_fecha',
            //'texto:ntext',
            ['class' => 'yii\grid\DataColumn','attribute' => 'comentario_id','content'=>function ($model){return '<a href="index.php?r=alerta-comentarios%2Fview&id='.$model->comentario_id.'">'.$model->comentario_id.'</a>';}],
            //'cerrado',
            //'num_denuncias',
            //'fecha_denuncia1',
            //'bloqueado',
            //'bloqueo_usuario_id',
            //'bloqueo_fecha',
            //'bloqueo_notas:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
