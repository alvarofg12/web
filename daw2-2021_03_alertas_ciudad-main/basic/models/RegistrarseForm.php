<?php

namespace app\models;
use Yii;
use yii\base\model;
use app\models\Users;

class RegistrarseForm extends model{
 
    public $email;
    public $password;
    public $password_repeat;
    public $nick;
    public $nombre;
    public $apellidos;
    
    public function rules()
    {
        return [
            [['email', 'password', 'password_repeat', 'nick', 'nombre', 'apellidos',], 'required', 'message' => 'Campo requerido'],
            ['email', 'match', 'pattern' => "/^.{5,80}$/", 'message' => 'Mínimo 5 y máximo 80 caracteres'],
            ['email', 'email', 'message' => 'Formato no válido'],
            ['email', 'email_existe'],
            ['password', 'match', 'pattern' => "/^.{6,20}$/", 'message' => 'Mínimo 6 y máximo 20 caracteres'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Los passwords no coinciden'],
        ];
    }
    
    public function email_existe($attribute, $params)
    {
  
        //Buscar el email en la tabla
        $table = Users::find()->where("email=:email", [":email" => $this->email]);
  
        //Si el email existe mostrar el error
        if ($table->count() == 1)
        {
            $this->addError($attribute, "El email seleccionado ya existe");
        }
    }
 
}



