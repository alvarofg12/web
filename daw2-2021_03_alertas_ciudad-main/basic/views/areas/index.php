<?php

use yii\helpers\Html;
use yii\grid\GridView;

echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">';

/* @var $this yii\web\View */
/* @var $searchModel app\models\AreasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Areas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="areas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Areas', ['create','id'=>0], ['class' => 'btn btn-success']) ?>
    </p>

    <p>
        <?= Html::a('Usuarios Area Moderacion', ['/usuarios-area-moderacion/index'], ['class' => 'btn btn-danger']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'clase_area_id',
            'nombre',
            'area_id',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {create}',
            'buttons'=>[
                'create'=>function ($url) {
                    return Html::a('<span class="material-icons md-light md-inactive">add</span>', $url, ['class' => 'glyphicon glyphicon-plus btn btn-default btn-xs custom_button']);
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
