<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property int $id
 * @property string $crea_fecha Fecha y Hora del mensaje de LOG.
 * @property string $clase_log_id código de clase de log: E=Error, A=Aviso, S=Seguimiento, I=Información, D=Depuración, ...
 * @property string|null $modulo Modulo o Sección de la aplicación que ha generado el mensaje de LOG.
 * @property string|null $texto Texto con el mensaje de LOG.
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['crea_fecha', 'clase_log_id'], 'required'],
            [['crea_fecha'], 'safe'],
            [['texto'], 'string'],
            [['clase_log_id'], 'string', 'max' => 1],
            [['modulo'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'crea_fecha' => 'Crea Fecha',
            'clase_log_id' => 'Clase Log ID',
            'modulo' => 'Modulo',
            'texto' => 'Texto',
        ];
    }
}
