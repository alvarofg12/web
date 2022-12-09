<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alerta_comentarios".
 *
 * @property int $id
 * @property int $alerta_id Alerta relacionada
 * @property int|null $crea_usuario_id Usuario que ha creado el comentario o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.
 * @property string|null $crea_fecha Fecha y Hora de creación del comentario o NULL si no se conoce por algún motivo.
 * @property int|null $modi_usuario_id Usuario que ha modificado el comentario por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.
 * @property string|null $modi_fecha Fecha y Hora de la última modificación del comentario o NULL si no se conoce por algún motivo.
 * @property string $texto El texto del comentario.
 * @property int|null $comentario_id Comentario relacionado, si se permiten encadenar respuestas. Nodo padre de la jerarquia de comentarios, CERO si es nodo raiz.
 * @property int $cerrado Indicador de cierre de los comentarios: 0=No, 1=Si(No se puede responder al comentario)
 * @property int $num_denuncias Contador de denuncias del comentario o CERO si no ha tenido.
 * @property string|null $fecha_denuncia1 Fecha y Hora de la primera denuncia. Debería estar a NULL si no tiene denuncias (contador a cero), o si el contador se reinicia.
 * @property int $bloqueado Indicador de comentario bloqueado: 0=No, 1=Si(bloqueado por denuncias), 2=Si(bloqueado por administrador), 3=Si(bloqueado por moderador), ...
 * @property int|null $bloqueo_usuario_id Usuario que ha bloqueado el comentario o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.
 * @property string|null $bloqueo_fecha Fecha y Hora del bloqueo del comentario. Debería estar a NULL si no está bloqueado o si se desbloquea.
 * @property string|null $bloqueo_notas Notas visibles sobre el motivo del bloqueo del comentario o NULL si no hay -se muestra por defecto según indique "bloqueado"-.
 */
class AlertaComentarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alerta_comentarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['alerta_id', 'texto'], 'required'],
            [['alerta_id', 'crea_usuario_id', 'modi_usuario_id', 'comentario_id', 'cerrado', 'num_denuncias', 'bloqueado', 'bloqueo_usuario_id'], 'integer'],
            [['crea_fecha', 'modi_fecha', 'fecha_denuncia1', 'bloqueo_fecha'], 'safe'],
            [['texto', 'bloqueo_notas'], 'string'],
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
            'crea_usuario_id' => 'Crea Usuario ID',
            'crea_fecha' => 'Crea Fecha',
            'modi_usuario_id' => 'Modi Usuario ID',
            'modi_fecha' => 'Modi Fecha',
            'texto' => 'Texto',
            'comentario_id' => 'Comentario ID',
            'cerrado' => 'Cerrado',
            'num_denuncias' => 'Num Denuncias',
            'fecha_denuncia1' => 'Fecha Denuncia1',
            'bloqueado' => 'Bloqueado',
            'bloqueo_usuario_id' => 'Bloqueo Usuario ID',
            'bloqueo_fecha' => 'Bloqueo Fecha',
            'bloqueo_notas' => 'Bloqueo Notas',
        ];
    }
}
