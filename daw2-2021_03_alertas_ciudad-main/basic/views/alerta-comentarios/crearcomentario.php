<?php

use yii\helpers\Html;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/* @var $this yii\web\View */
/* @var $model app\models\AlertaComentarios */

$this->title = 'Publicar Comentario';
?>
<div class="alerta-comentarios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPublico', [
        'model' => $model,
    ]) ?>

</div>
