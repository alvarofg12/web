<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario_incidencias".
 *
 * @property int $id
 * @property string $crea_fecha Fecha y Hora de creación de la incidencia.
 * @property string $clase_incidencia_id código de clase de incidencia: A=Aviso, N=Notificación, D=Denuncia, C=Consulta, M=Mensaje Genérico,...
 * @property string|null $texto Texto con el mensaje de incidencia.
 * @property int|null $destino_usuario_id Usuario relacionado, destinatario de la incidencia, o NULL si no es para administración y no está gestionado.
 * @property int|null $origen_usuario_id Usuario relacionado, origen de la incidencia, o NULL si es del sistema.
 * @property int|null $alerta_id alerta relacionada o NULL si no tiene que ver con una alerta.
 * @property int|null $comentario_id Comentario relacionado o NULL si no tiene que ver con un comentario.
 * @property string|null $fecha_lectura Fecha y Hora de lectura de la incidencia o NULL si no se ha leido o se ha desmarcado como tal.
 * @property string|null $fecha_borrado Fecha y Hora de la marca de borrado de la incidencia o NULL si no se ha marcado como borrado.
 * @property string|null $fecha_aceptado Fecha y Hora de aceptación de la incidencia o NULL si no se ha aceptado para su gestión por un moderador o administrador. No se usa en otros usuarios.
 */
class UsuarioIncidencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario_incidencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['crea_fecha'], 'required'],
            [['crea_fecha', 'fecha_lectura', 'fecha_borrado', 'fecha_aceptado'], 'safe'],
            [['texto'], 'string'],
            [['destino_usuario_id', 'origen_usuario_id', 'alerta_id', 'comentario_id'], 'integer'],
            [['clase_incidencia_id'], 'string', 'max' => 1],
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
            'clase_incidencia_id' => 'Clase Incidencia ID',
            'texto' => 'Texto',
            'destino_usuario_id' => 'Destino Usuario ID',
            'origen_usuario_id' => 'Origen Usuario ID',
            'alerta_id' => 'Alerta ID',
            'comentario_id' => 'Comentario ID',
            'fecha_lectura' => 'Fecha Lectura',
            'fecha_borrado' => 'Fecha Borrado',
            'fecha_aceptado' => 'Fecha Aceptado',
        ];
    }
}
