<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\UsuarioIncidenciasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Incidencias del Usuario';
?>
<div class="usuario-incidencias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Nueva Incidencia', ['usuario-incidencias/createpublico'], ['class' => 'btn btn-success']) ?>
    </p>

    <h2>Incidencias Recibidas</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProviderD,
        'filterModel' => $searchModelD,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'crea_fecha',
            'texto:ntext',
     ],
    ]); ?>

<h2>Incidencias Enviadas</h2>

<?= GridView::widget([
    'dataProvider' => $dataProviderO,
    'filterModel' => $searchModelO,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'crea_fecha',
        'texto:ntext',
 ],
]); ?>


</div>

