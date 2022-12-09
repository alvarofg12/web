<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Usuarios;
use app\models\Areas;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuariosAreaModeracionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios Area Moderacions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-area-moderacion-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuarios Area Moderacion', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'usuario_id',
           // 'usuario',
            [
                'attribute' => 'usuario_id',
                'label'=> 'Usuario',
                'value'     => function($model){return Usuarios::findOne($model->usuario_id)->nick; }
            ],

            [
                'attribute' => 'area_id',
                'label'=> 'Area',
                'value'     => function($model){return Areas::findOne($model->area_id)->nombre; }
            ],

            //'area_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
