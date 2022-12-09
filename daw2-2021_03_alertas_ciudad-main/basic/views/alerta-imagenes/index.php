<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaImagenesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alerta Imagenes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alerta-imagenes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Alerta Imagenes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            ['class' => 'yii\grid\DataColumn','attribute' => 'alerta_id','content'=>function ($model){return '<a href="index.php?r=alertas%2Fview&id='.$model->alerta_id.'">'.$model->alerta_id.'</a>';}],
            'orden',
            ['class' => 'yii\grid\DataColumn','attribute' => 'imagen_id','content'=>function ($model){return '<a href="index.php?r=alerta-imagenes%2Fview&id='.$model->imagen_id.'">'.$model->imagen_id.'</a>';}],
            //'imagen_revisada',
            ['class' => 'yii\grid\DataColumn','attribute' => 'crea_usuario_id','content'=>function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->crea_usuario_id.'">'.$model->crea_usuario_id.'</a>';}],
            'crea_fecha',
            ['class' => 'yii\grid\DataColumn','attribute' => 'modi_usuario_id','content'=>function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->modi_usuario_id.'">'.$model->modi_usuario_id.'</a>';}],
            //'modi_fecha',
            //'notas_admin:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
