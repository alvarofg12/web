<?php

use yii\helpers\Html;
use yii\grid\GridView;

echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">';
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index" align="center">
    <img src="../img/logo.png" width="30%"> </div>
    <div class="textoplano">
        <hr>Portal Web sobre la Publicación y Gestión de Alertas, Avisos, Sucesos, Eventos que ocurren en tu Ciudad o cercanías.<br>
        En este portal se podrán ver, buscar y consultar las Alertas que se activen en el sistema por cualquiera de los usuarios 
        registrados o dados de alta en el sistema.<hr>
        
    </div>

    
<div class="areas-index">

<center ><h1>ULTIMAS ALERTAS</h1></center>

<?=

/*foreach ($dataProvider as $valor)
{
    var_dump($valor);
    echo "<hr>";
}*/

GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'summary' => "",
    'showHeader' => false,
    'columns' => [
       'titulo',
        ['class' => 'yii\grid\ActionColumn',
        'header' => 'Ver ficha ',
        'template' => '{view}',
        'buttons'=>[

            'view'=>function ($url,$model) {
                $base= explode('&',$url);
                return Html::a('<span class="material-icons md-light md-inactive">add</span>', 'index.php?r=alertas%2Fviewpublico&id='.$model->id, ['class' => 'glyphicon glyphicon-plus btn btn-default btn-xs custom_button']);
            },
    
        ],
/*
        'urlCreator' =>function ($accion,$model,$key,$index){
            if($accion == 'view') return "index.php?r=site%2Fview&id=".$model->titulo."";
            //if($accion == 'view') return "index.php?r=site%2Fview&id=0";
            
        }*/

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

</div>
