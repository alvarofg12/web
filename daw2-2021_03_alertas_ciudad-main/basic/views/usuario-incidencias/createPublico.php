<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UsuarioIncidencias */

$this->title = 'Crear Incidencia Usuario';
?>
<div class="usuario-incidencias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formPublico', [
        'model' => $model,
    ]) ?>

</div>
