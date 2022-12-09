<?php

use yii\helpers\Html;
use yii\grid\GridView;

echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">';

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlertaComentariosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comentarios';
?>
<div class="alerta-comentarios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'alerta_id',
            //'crea_usuario_id',
            //'crea_fecha',
            //'modi_usuario_id',
            //'modi_fecha',
            'texto:ntext',
            //'comentario_id',
            //'cerrado',
            'num_denuncias',
            //'fecha_denuncia1',
            //'bloqueado',
            //'bloqueo_usuario_id',
            //'bloqueo_fecha',
            //'bloqueo_notas:ntext',

           ['class' => 'yii\grid\ActionColumn',
            'header' => ' Ver comentario',
            'template' => '{vistac}',
            'buttons'=>[
                'vistac'=>function ($url,$model) {
                    $base= explode('&',$url);
                    return Html::a('<span class="material-icons md-light md-inactive">chat</span>', ['alerta-comentarios/vistac','id' => $model->id], ['class' => 'btn btn-success']);
                }],  
            ],
            ['class' => 'yii\grid\ActionColumn',
            'header' => ' Denunciar',
            'template' => '{denunciar}',
            'buttons'=>[
                'denunciar'=>function ($url,$model) {
                    $base= explode('&',$url);
                    return Html::a('<span class="material-icons md-light md-inactive">warning</span>', ['alerta-comentarios/denuncia','id' => $model->id], ['class' => 'btn btn-danger']);
                }],
            ],
            ['class' => 'yii\grid\ActionColumn',
            'header' => ' Responder',
            'template' => '{responder}',
            'buttons'=>[
                'responder'=>function ($url,$model) {
                    $base= explode('&',$url);
                    return Html::a('<span class="material-icons md-light md-inactive">reply</span>', ['alerta-comentarios/respondercomentario','alerta_id' => $model->alerta_id,'id' => $model->id], ['class' => 'btn btn-success']);
                }],],
            ['class' => 'yii\grid\ActionColumn',
            'header' => ' Respuestas',
            'template' => '{respuesta}',
            'buttons'=>[
                'respuesta'=>function ($url,$model) {
                    $base= explode('&',$url);
                    
                    return '<a href="index.php?AlertaComentariosSearch[comentario_id]='.$model->id.'&r=site%2Fcomentarios"><span class="material-icons md-light md-inactive">sticky_note_2</span></a>';
                }
            

           ],
        ],
        ],
    ]); ?>


    <p>
        <?= Html::a('Volver', ['alertas'], ['class' => 'btn btn-primary']) ?>

    </p>


</div>
