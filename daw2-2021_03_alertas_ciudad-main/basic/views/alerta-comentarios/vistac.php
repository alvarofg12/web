<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = 'Comentario';
\yii\web\YiiAsset::register($this);
?>
<div class="alerta-comentarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            //'crea_usuario_id',
            //'crea_fecha',
            /*'modi_usuario_id',
            'modi_fecha',
            */'texto:ntext',/*
            'comentario_id',
            'cerrado',
            */'num_denuncias',/*
            */'fecha_denuncia',/*
            'bloqueado',
            'bloqueo_usuario_id',
            'bloqueo_fecha',
            'bloqueo_notas:ntext',*/
        ],
    ]) ?>


    <p>
        <?= Html::a('Volver', ['site/comentarios','AlertaComentariosSearch[alerta_id]='=>$model->alerta_id], ['class' => 'btn btn-primary']) ?>
        
    </p>

</div>
