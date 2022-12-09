<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alertas".
 *
 * @property int $id
 * @property string $titulo Titulo corto para la alerta.
 * @property string|null $descripcion Descripción breve de la alerta o NULL si no es necesaria.
 * @property string|null $fecha_inicio Fecha y Hora de inicio/activación de la alerta o NULL si no se conoce (mostrar próximamente).
 * @property int $duracion_estimada Tiempo en Minutos de duración estimada de la alerta, si es CERO no se conoce o no es relevante.
 * @property string|null $direccion Dirección concreta del lugar de la alerta o NULL si no se conoce, aunque no debería estar vacío este dato.
 * @property string|null $notas_lugar Notas adicionales sobre el lugar de la alerta que no forman parte de la dirección o de las indicaciones, o NULL si no hay.
 * @property int|null $area_id Area/Zona de la alerta o CERO si no existe o aún no está indicado (como si fuera NULL).
 * @property string|null $detalles Detalles de la alerta si es necesario o NULL si no hay.
 * @property string|null $notas Notas adicionales sobre la alerta que no forman parte de las posibles notas anteriores o NULL si no hay.
 * @property string|null $url Dirección web externa (opcional) que enlaza con otra página o NULL si no hay.
 * @property string|null $imagen_id Nombre identificativo (fichero interno) con la imagen principal o "de presentación" de la alerta, o NULL si no hay.
 * @property int $imagen_revisada Indicador de imagen revisada por un administrador o moderador: 0=No, 1=Si.
 * @property int|null $categoria_id Categoría de la alerta o CERO si no existe o aún no está indicada (como si fuera NULL).
 * @property int $activada Indicador de alerta para mostrar la alerta a los usuarios o solo para los creadores/administraddores: 0=Desactivada, 1=Activa.
 * @property int $visible Indicador de alerta visible a los usuarios o invisible (se está manteniendo): 0=Invisible, 1=Visible.
 * @property int $terminada Indicador de alerta terminada: 0=No, 1=Realizada, 2=Suspendida, 3=Cancelada por Inadecuada, ...
 * @property string|null $fecha_terminacion Fecha y Hora de terminación de la alerta. Debería estar a NULL si no está terminada.
 * @property string|null $notas_terminacion Notas visibles sobre el motivo de la terminación de la alerta.
 * @property int $num_denuncias Contador de denuncias de la alerta o CERO si no ha tenido.
 * @property string|null $fecha_denuncia1 Fecha y Hora de la primera denuncia. Debería estar a NULL si no tiene denuncias (contador a cero), o si el contador se reinicia.
 * @property int $bloqueada Indicador de alerta bloqueada: 0=No, 1=Si(bloqueada por denuncias), 2=Si(bloqueada por administrador), 3=Si(bloqueada por moderador), ...
 * @property int|null $bloqueo_usuario_id Usuario que ha bloqueado la alerta o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.
 * @property string|null $bloqueo_fecha Fecha y Hora del bloqueo de la alerta. Debería estar a NULL si no está bloqueada o si se desbloquea.
 * @property string|null $bloqueo_notas Notas visibles sobre el motivo del bloqueo de la alerta o NULL si no hay -se muestra por defecto según indique "bloqueada"-.
 * @property int|null $crea_usuario_id Usuario que ha creado la alerta o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.
 * @property string|null $crea_fecha Fecha y Hora de creación de la alerta o NULL si no se conoce por algún motivo.
 * @property int|null $modi_usuario_id Usuario que ha modificado la alerta por última vez o CERO (como si fuera NULL) si no existe o se hizo por un administrador de sistema.
 * @property string|null $modi_fecha Fecha y Hora de la última modificación de la alerta o NULL si no se conoce por algún motivo.
 * @property string|null $notas_admin Notas adicionales para los administradores sobre la alerta o NULL si no hay.
 */
class Alertas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alertas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['titulo', 'descripcion', 'direccion', 'notas_lugar', 'detalles', 'notas', 'url', 'notas_terminacion', 'bloqueo_notas', 'notas_admin'], 'string'],
            [['fecha_inicio', 'fecha_terminacion', 'fecha_denuncia1', 'bloqueo_fecha', 'crea_fecha', 'modi_fecha'], 'safe'],
            [['duracion_estimada', 'area_id', 'imagen_revisada', 'categoria_id', 'activada', 'visible', 'terminada', 'num_denuncias', 'bloqueada', 'bloqueo_usuario_id', 'crea_usuario_id', 'modi_usuario_id'], 'integer'],
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
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'fecha_inicio' => 'Fecha Inicio',
            'duracion_estimada' => 'Duracion Estimada',
            'direccion' => 'Direccion',
            'notas_lugar' => 'Notas Lugar',
            'area_id' => 'Area ID',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url' => 'Url',
            'imagen_id' => 'Imagen ID',
            'imagen_revisada' => 'Imagen Revisada',
            'categoria_id' => 'Categoria ID',
            'activada' => 'Activada',
            'visible' => 'Visible',
            'terminada' => 'Terminada',
            'fecha_terminacion' => 'Fecha Terminacion',
            'notas_terminacion' => 'Notas Terminacion',
            'num_denuncias' => 'Num Denuncias',
            'fecha_denuncia1' => 'Fecha Denuncia1',
            'bloqueada' => 'Bloqueada',
            'bloqueo_usuario_id' => 'Bloqueo Usuario ID',
            'bloqueo_fecha' => 'Bloqueo Fecha',
            'bloqueo_notas' => 'Bloqueo Notas',
            'crea_usuario_id' => 'Crea Usuario ID',
            'crea_fecha' => 'Crea Fecha',
            'modi_usuario_id' => 'Modi Usuario ID',
            'modi_fecha' => 'Modi Fecha',
            'notas_admin' => 'Notas Admin',
        ];
    }
}
