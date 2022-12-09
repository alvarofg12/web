<?php

namespace app\models;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    
    public $id;
    public $email;
    public $password;
    public $nick;
    public $rol;
    public $nombre;
    public $apellidos;
    public $fecha_nacimiento;
    public $direccion;
    public $area_id;
    public $fecha_registro;
    public $fecha_acceso;
    public $num_accesos;
    public $confirmado;
    public $bloqueado;
    public $bloqueo_usuario_id;
    public $bloqueo_fecha;
    public $bloqueo_notas;
    public $authKey;
    public $accessToken;


    /**
     * @inheritdoc
     */
    
    /* busca la identidad del usuario a través de su $id */

    public static function findIdentity($id)
    {
        
        $user = Users::find()
                ->where("confirmado=:confirmado", [":confirmado" => 1])
                ->andwhere("bloqueado=:bloqueado", ["bloqueado" => 0])
                ->andWhere("id=:id", ["id" => $id])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    
    /* Busca la identidad del usuario a través de su token de acceso */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        
        $users = Users::find()
                ->where("confirmado=:confirmado", [":confirmado" => 1])
                ->andwhere("bloqueado=:bloqueado", ["bloqueado" => 0])
                ->andWhere("accessToken=:accessToken", [":accessToken" => $token])
                ->all();
        
        foreach ($users as $user) {
            if ($user->accessToken === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by email
     *
     * @param  string      $email
     * @return static|null
     */
    
    /* Busca la identidad del usuario a través del email */
    public static function findByUsername($email)
    {
        $users = Users::find()
                ->where("confirmado=:confirmado", ["confirmado" => 1])
                ->andwhere("bloqueado=:bloqueado", ["bloqueado" => 0])
                ->andWhere("email=:email", [":email" => $email])
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->email, $email) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa el id del usuario */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa la clave de autenticación */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    
    /* Valida la clave de autenticación */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        //$decodificado = \Yii::$app->getSecurity()->decryptByPassword(base64_decode($this->password),\Yii::$app->params["salt"]);
        //$codificado = base64_encode(\Yii::$app->getSecurity()->encryptByPassword($password, $clavesecreta));
        /* Valida el password */
        //if ($this->password == $password/*$decodificado)crypt($password, 'encriptar')*/)
        if(crypt($password,$this->password)== $this->password)
        {
            return $password === $password;
            //return $this->password === hash("sha1", $password);
        }
    }

    /*public function authenticate($attribute,$params)
    {

    }*/
}