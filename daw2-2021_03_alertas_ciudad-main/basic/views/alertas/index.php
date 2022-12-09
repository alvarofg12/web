<?php

use yii\helpers\Html;
use yii\grid\GridView;

echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">';

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alertas';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="alertas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Alertas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'titulo:ntext',
            'descripcion:ntext',
            'fecha_inicio',
            'duracion_estimada',
            'direccion:ntext',
            //'notas_lugar:ntext',
            ['class' => 'yii\grid\DataColumn','attribute' => 'area_id','content'=>function ($model){return '<a href="index.php?r=areas%2Fview&id='.$model->area_id.'">'.$model->area_id.'</a>';}],

            //'detalles:ntext',
            //'notas:ntext',
            //'url:ntext',
            ['class' => 'yii\grid\DataColumn','attribute' => 'imagen_id','content'=>function ($model){return '<a href="index.php?r=alerta-imagenes%2Fview&id='.$model->imagen_id.'">'.$model->imagen_id.'</a>';}],
            //'imagen_revisada',
            ['class' => 'yii\grid\DataColumn','attribute' => 'categoria_id','content'=>function ($model){return '<a href="index.php?r=categorias%2Fview&id='.$model->categoria_id.'">'.$model->categoria_id.'</a>';}],
            //'activada',
            'visible',
            //'terminada',
            'fecha_terminacion',
            //'notas_terminacion:ntext',
            'num_denuncias',
            //'fecha_denuncia1',
            'bloqueada',
            //'bloqueo_usuario_id',
            //'bloqueo_fecha',
            //'bloqueo_notas:ntext',
            ['class' => 'yii\grid\DataColumn','attribute' => 'crea_usuario_id','content'=>function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->crea_usuario_id.'">'.$model->crea_usuario_id.'</a>';}],
            'crea_fecha',
            ['class' => 'yii\grid\DataColumn','attribute' => 'modi_usuario_id','content'=>function ($model){return '<a href="index.php?r=usuarios%2Fview&id='.$model->modi_usuario_id.'">'.$model->modi_usuario_id.'</a>';}],
            //'modi_fecha',
            //'notas_admin:ntext',
            //etiquetas
            //comentarios

            ['class' => 'yii\grid\ActionColumn',
            'header' => 'Comentarios',
            'template' => '{comentarios}',
            'buttons'=>[
                'comentarios'=>function ($url,$model) {
                    $base= explode('&',$url);
                    return Html::a('<span class="material-icons md-light md-inactive">chat</span>', $url,['class' => 'glyphicon glyphicon-plus btn btn-default btn-xs custom_button']);
                }],
                'urlCreator'=> function ($action, $model, $key, $index) {
                    if ($action === 'comentarios') {
                        return 'index.php?AlertaComentariosSearch[alerta_id]='.$model->id.'&r=alerta-comentarios%2Findex';
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],

            /* todas las pruevas hasta dar con la solucion
            ['header' => 'area_id',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{consultar}',
                'buttons'=>[
                    'consultar'=>function ($url, $model) {
                        return Html::a($model->area_id, $url);
                    },
                ],

                'urlCreator'=> function ($action, $model, $key, $index) {
                    if ($action === 'consultar') {
                        return 'index.php?AlertaComentariosSearch[alerta_id]='.$model->area_id.'&r=alerta-comentarios%2Findex';
                    }
                }
            ],
             ['attribute' => 'area_id',
                'class' => 'yii\grid\DataColumn',
                'content' => function ($url, $model, $key, $index) {
                        return '<a href="index.php?AlertaComentariosSearch[alerta_id]=22&r=alerta-comentarios%2Findex">hola</a>';},
            ],
            /*[
                'class' => 'yii\grid\DataColumn',
                'content' => function ($url, $model, $key, $index) {
                    if ($model->area_id) {
                        return $model->area_id;
                    }
                        
                        },
            ],
            [
            'attribute' => 'area_id',
            'content'=>function ($model){
                return '<a href="index.php?AlertaComentariosSearch[alerta_id]='.$model->area_id.'&r=alerta-comentarios%2Findex">'.$model->area_id.'</a>';
            }

        ]*/],
    ]); ?>


</div>

