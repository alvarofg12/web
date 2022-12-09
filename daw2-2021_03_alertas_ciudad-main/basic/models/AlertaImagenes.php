<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alerta_imagenes".
 *
 * @property int $id
 * @property int $alerta_id Alerta relacionada
 * @property int $orden Orden de aparición de la imagen dentro del grupo de imagenes de la alerta. Opcional.
 * @property string $imagen_id Nombre identificativo (fichero interno) con la imagen para la alerta, aqui no puede ser NULL si no hay.
 * @property int $imagen_revisada Indicador de imagen revisada por un administrador o moderador: 0=No, 1=Si.
 * @property int|null $crea_usuario_id Usuario que ha creado la alerta o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.
 * @property string|null $crea_fecha Fecha y Hora de creación de la alerta o NULL si no se conoce por algún motivo.
 * @property int|null $modi_usuario_id Usuario que ha modificado la alerta por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.
 * @property string|null $modi_fecha Fecha y Hora de la última modificación de la alerta o NULL si no se conoce por algún motivo.
 * @property string|null $notas_admin Notas adicionales para los administradores sobre la alerta o NULL si no hay.
 */
class AlertaImagenes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alerta_imagenes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alerta_id', 'imagen_id'], 'required'],
            [['alerta_id', 'orden', 'imagen_revisada', 'crea_usuario_id', 'modi_usuario_id'], 'integer'],
            [['crea_fecha', 'modi_fecha'], 'safe'],
            [['notas_admin'], 'string'],
            [['imagen_id'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alerta_id' => 'Alerta ID',
            'orden' => 'Orden',
            'imagen_id' => 'Imagen ID',
            'imagen_revisada' => 'Imagen Revisada',
            'crea_usuario_id' => 'Crea Usuario ID',
            'crea_fecha' => 'Crea Fecha',
            'modi_usuario_id' => 'Modi Usuario ID',
            'modi_fecha' => 'Modi Fecha',
            'notas_admin' => 'Notas Admin',
        ];
    }
}
