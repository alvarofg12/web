<?php

use yii\helpers\Html;
use yii\grid\GridView;

echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">';

/* @var $this yii\web\View */
/* @var $searchModel app\models\AreasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Areas';
?>
<div class="areas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
          //  'clase_area_id',
            'nombre',
           // 'area_id',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {alertas}',
            'buttons'=>[
                'alertas'=>function ($url,$model) {
                    $base= explode('&',$url);
                    return Html::a('<span class="material-icons md-light md-inactive">warning</span>', $base[0]."&AlertasSearch%5Barea_id%5D=".$model->id, ['class' => 'glyphicon glyphicon-plus btn btn-default btn-xs custom_button']);
                },

                'view'=>function ($url,$model) {
                    $base= explode('&',$url);
                    return Html::a('<span class="material-icons md-light md-inactive">warning</span>', $base[0]."&AlertasSearch%5Barea_id%5D=".$model->id, ['class' => 'glyphicon glyphicon-plus btn btn-default btn-xs custom_button']);
                },
                
            ],
           //'urlCreator'=> function ($action, $model, $key, $index) {
               // if ($action === 'new') {
                  //  return 'index.php?AlertaComentariosSearch[alerta_id]='.$model->area_id.'&r=alerta-comentarios%2Findex';
               // }
            //],
        ],

    ],
    ]); 
    
    if(isset($error)){
        if($error=='1010'){
            echo '<script>alert("No se pueden borrar areas que contengan subareas")</script>';
        }
    }
    
    ?>



</div>
