<?php


use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\UsuarioIncidencias;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->email;

\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
        if(isset($_GET['rolnuevo'])){
            Yii::$app->user->identity->rol=$_GET['rolnuevo'];
            $model->rol = $_GET['rolnuevo'];
    
        }
        if($model->rol == 'S'){ $model->rol = 'Administrador del Sistema';}
        if($model->rol == 'A'){ $model->rol = 'Administrador';}
        if($model->rol == 'M'){ $model->rol = 'Moderador';}
        if($model->rol == 'N'){ $model->rol = 'Usuario';}
        if(isset($_GET['incidencia']))
        { 
            $model2 = new UsuarioIncidencias();
            $model2->crea_fecha=date("Y-m-d H:m:s");
            $model2->clase_incidencia_id="B";
            $model2->texto="Baja de usuario";
            $model2->destino_usuario_id="0";
            $model2->origen_usuario_id=Yii::$app->user->id;
            $model2->insert();
        } 
   
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'email:email',
            'nick',
            'nombre',
            'apellidos',
            'fecha_nacimiento',
            'direccion:ntext',
            'rol',
            'fecha_registro',

        ],
    ]) ?>

</div>
<?= Html::a('Cambiar datos', ['usuarios/updatepublico', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
<hr>
<?= Html::a('Solicitar baja', ['perfil', 'id' => $model->id, 'incidencia'=>'1'], ['class' => 'btn btn-danger']) ?>
<hr>
<?php 

if($model->rol == 'Administrador del Sistema')
{ ?>
    <?= Html::a('Cambiar a usuario', ['perfil', 'id' => $model->id, 'rolnuevo' => 'N'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Cambiar a moderador', ['perfil', 'id' => $model->id, 'rolnuevo' => 'M'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Cambiar a administrador', ['perfil', 'id' => $model->id, 'rolnuevo' => 'A'], ['class' => 'btn btn-primary']) ?>
    <hr><p>Para volver a tener el rol de administrador de sistema, vuelva a iniciar sesion</p>
    <?php


}

?>