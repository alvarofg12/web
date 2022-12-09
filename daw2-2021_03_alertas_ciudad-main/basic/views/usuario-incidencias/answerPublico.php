<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencias */

//esta es la vista para responder a las incidencias

$this->title = 'Answer Usuario Incidencias';
?>
<div class="usuario-incidencias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPublico', [
        'model' => $model,
    ]) ?>

</div>
