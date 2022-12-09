<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $email Correo Electronico y "login" del usuario.
 * @property string $password
 * @property string $nick
 * @property string $nombre
 * @property string $apellidos
 * @property string|null $fecha_nacimiento Fecha de nacimiento del usuario o NULL si no lo quiere informar.
 * @property string|null $direccion Direccion del usuario o NULL si no quiere informar.
 * @property int $area_id Area/Zona de localización del usuario o CERO si no lo quiere informar (como si fuera NULL), aunque es recomendable.
 * @property string $rol Código de la Clase / Tipo de Perfil: N=Normal, M=Moderador, A=Administrador, S=SysAdmin
 * @property string|null $fecha_registro Fecha y Hora de registro del usuario o NULL si no se conoce por algún motivo (que no debería ser).
 * @property int $confirmado Indicador de usuario ha confirmado su registro o no.
 * @property string|null $fecha_acceso Fecha y Hora del ultimo acceso del usuario. Debería estar a NULL si no ha accedido nunca.
 * @property int $num_accesos Contador de accesos fallidos del usuario o CERO si no ha tenido o se ha reiniciado por un acceso valido o por un administrador.
 * @property int $bloqueado Indicador de usuario bloqueado: 0=No, 1=Si(bloqueado por fallos de acceso), 2=Si(bloqueado por administrador), 3=Si(bloqueado por moderador), ...
 * @property int|null $bloqueo_usuario_id Usuario que ha bloqueado el usuario o CERO (como si fuera NULL) si no existe o se hizo automáticamente por el sistema.
 * @property string|null $bloqueo_fecha Fecha y Hora del bloqueo del usuario. Debería estar a NULL si no está bloqueado o si se desbloquea.
 * @property string|null $bloqueo_notas Notas visibles sobre el motivo del bloqueo del usuario o NULL si no hay -se muestra por defecto según indique "bloqueado"-.
 */
class Usuarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'password', 'nick', 'nombre', 'apellidos', 'rol', 'confirmado'], 'required'],
            [['fecha_nacimiento', 'fecha_registro', 'fecha_acceso', 'bloqueo_fecha'], 'safe'],
            [['direccion', 'bloqueo_notas'], 'string'],
            [['area_id', 'confirmado', 'num_accesos', 'bloqueado', 'bloqueo_usuario_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['nick'], 'string', 'max' => 25],
            [['nombre'], 'string', 'max' => 50],
            [['apellidos'], 'string', 'max' => 100],
            [['rol'], 'string', 'max' => 1],
            [['email'], 'unique'],
            [['nick'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'nick' => 'Nick',
            'nombre' => 'Nombre',
            'apellidos' => 'Apellidos',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'direccion' => 'Direccion',
            'area_id' => 'Area ID',
            'rol' => 'Rol',
            'fecha_registro' => 'Fecha Registro',
            'confirmado' => 'Confirmado',
            'fecha_acceso' => 'Fecha Acceso',
            'num_accesos' => 'Num Accesos',
            'bloqueado' => 'Bloqueado',
            'bloqueo_usuario_id' => 'Bloqueo Usuario ID',
            'bloqueo_fecha' => 'Bloqueo Fecha',
            'bloqueo_notas' => 'Bloqueo Notas',
        ];
    }
}
