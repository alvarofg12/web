<?php
namespace app\controllers;

use Yii;
# =========================================================== #
# LIBRERIAS PARA MANEJO DE DATOS, ESTRUCTURAS Y DEMAS 
# FUNCIONALIDADES DE LA PAGINA WEB
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

use yii\helpers\Url;
use yii\helpers\Html;

use yii\swiftmailer\Mailer;
use yii\data\SqlDataProvider;
use yii\widgets\ActiveForm;
# =========================================================== #
# MODELOS DE LOGIN,  CONTACTAR Y REGISTRARSE 
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrarseForm;
# =========================================================== #
# MODELOS RELACIONADOS CON LOS USUARIOS
use app\models\Users;
use app\models\Usuarios;
# =========================================================== #
# MODELOS RELACIONADOS CON LAS INCIDENCIAS
use app\models\UsuarioIncidencias;
use app\models\UsuarioIncidenciasSearch;
# =========================================================== #
# MODELOS RELACIONADOS CON LAS AREAS
use app\models\Areas;
use app\models\AreasSearch;
# =========================================================== #
# MODELOS RELACIONADOS CON LAS ALERTAS
use app\models\Alertas;
use app\models\AlertasSearch;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use app\models\AlertasPortadaSearch;
# =========================================================== #


class SiteController extends Controller
{
    # =========================================================== #
    # PERMISOS
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    # =========================================================== #
    # ACCIONES
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    # =========================================================== #
    # ACCION RELACIONADA CON LA VISTA PUBLICA PORTADA
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AlertasPortadaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        return $this->render('index',
        [   'searchModel'      => $searchModel,
            'dataProvider'      => $dataProvider,
        ]);
                
    }

    # =========================================================== #
    #ACCION RELACIONADA CON LA VISTA LOGIN / LOGOUT
    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) { return $this->goHome();}

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {return $this->goBack();}

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    # =========================================================== #
    # ACCION RELACIONADA CON VISTA CONTACTANOS
    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    # =========================================================== #
    # ACCION RELACIONADA CON LA VISTA SOBRE NOSOTROS
    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(){return $this->render('about');}


    
    # =========================================================== #
    # ACCION RELACIONADA CON LAS ALERTAS Y SUS COMENTARIOS
    /**
     * Displays alertas.
     *
     * @return string
     */
    public function actionAlertas()
    {
        $searchModel = new AlertasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
    

        return $this->render('alertas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }


    /**
     * Displays alertas.
     *
     * @return string
     */
    public function actionComentarios()
    {
        $searchModel = new AlertaComentariosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
    

        return $this->render('comentarios', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
            
       
    }

    # =========================================================== #
    # ACCION RELACIONADA CON LA VISTA AREAS
    /**
     * Displays areas.
     *
     * @return string
     */
    public function actionAreas()
    {
        $searchModel = new AreasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
    
        return $this->render('areas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }


    
    # =========================================================== #
    # ACCION RELACIONADA CON LAS INCIDENCIAS
    /**
     * Displays incidencias.
     *
     * @return string
     */
    public function actionIncidencias()
    {

        if(Yii::$app->user->isGuest)
        {
            $model = new LoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {return $this->goBack();}
    
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
         }
        $searchModelD = new UsuarioIncidenciasSearch();
        $count = Yii::$app->db->createCommand
        ('SELECT COUNT(*) FROM usuario_incidencias WHERE destino_usuario_id = '.Yii::$app->user->id, [])->queryScalar();
        $dataProviderD = new SqlDataProvider([
            'sql' => 'SELECT * FROM usuario_incidencias WHERE destino_usuario_id = :destino',
            'params' => [':destino' => Yii::$app->user->id],
            'totalCount' => $count,
        ]);

        $searchModelO = new UsuarioIncidenciasSearch();
        $count = Yii::$app->db->createCommand
        ('SELECT COUNT(*) FROM usuario_incidencias WHERE origen_usuario_id = '.Yii::$app->user->id, [])->queryScalar();
        $dataProviderO = new SqlDataProvider([
            'sql' => 'SELECT * FROM usuario_incidencias WHERE origen_usuario_id = :origen',
            'params' => [':origen' => Yii::$app->user->id],
            'totalCount' => $count,
        ]);

        return $this->render('incidencias',
        [   'searchModelD'      => $searchModelD,
            'dataProviderD'      => $dataProviderD,
            'searchModelO'      => $searchModelO,
            'dataProviderO'      => $dataProviderO,

        ]);
    }

    # =========================================================== #
    # ACCION RELACIONADAS CON EL PERFIL DEL USUARIO
    /**
     * Displays perfil.
     *
     * @return string
     */
    public function actionPerfil()
    {
        $model = new Users();
        if (($model = Usuarios::findOne(Yii::$app->user->id)) !== null) {
            return $this->render("perfil", ["model" => $model,]);
        }

        return false;  
    }

    # =========================================================== #
    # ACCION RELACIONADA CON LA CREACION DE UNA COPIA DE SEGURIDAD
    /**
     * Displays copia de seguridad.
     *
     * @return string
     */
    public function actionCopiaseguridad(){return $this->render('copiaseguridad');   }
      
    # =========================================================== #
    # ACCION RELACIONADA CON el REGISTRO DE UN USUARIO
    /**
     * Displays confirmar el usuario.
     *
     * @return string
     */
    public function actionConfirm() //Confirmar correo
    {
       $table = new Users;
       if (Yii::$app->request->get())
       {
      
           //Obtenemos el valor de los parámetros get
           $id = Html::encode($_GET["id"]);
       
           if ((int) $id)
           {
               //Realizamos la consulta para obtener el registro
               $model = $table
               ->find()
               ->where("id=:id", [":id" => $id]);
    
               //Si el registro existe
               if ($model->count() == 1)
               {
                   $activar = Users::findOne($id);
                   $activar->confirmado = 1;
                   if ($activar->update())
                   {
                       echo "Enhorabuena registro llevado a cabo correctamente, redireccionando ...";
                       echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                   }
                   else
                   {
                       echo "Ha ocurrido un error al realizar el registro, redireccionando ...";
                       echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                   }
                }
               else //Si no existe redireccionamos a login
               {
                   return $this->redirect(["site/login"]);
               }
           }
           else //Si id no es un número entero redireccionamos a login
           {
               return $this->redirect(["site/login"]);
           }
       }
    }

    /**
     * Displays registrar el usuario en la base de datos.
     *
     * @return string
     */
    public function actionRegistrarse()
    {
        //Creamos la instancia con el model de validación
        $model = new RegistrarseForm;
      
        //Mostrará un mensaje en la vista cuando el usuario se haya registrado
        $msg = null;
      
        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
           Yii::$app->response->format = Response::FORMAT_JSON;
           return ActiveForm::validate($model);
       }
      
        //Validación cuando el formulario es enviado vía post
        //Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        //También previene por si el usuario tiene desactivado javascript y la
        //validación mediante ajax no puede ser llevada a cabo
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                //Preparamos la consulta para guardar el usuario
                $table = new Users;
                $table->email = $model->email;
                $table->nick = $model->nick;
                $table->nombre = $model->nombre;
                $table->apellidos = $model->apellidos;
                $table->rol = 'N';
                $table->fecha_registro = date("Y-m-d H:i:s");
                $table->confirmado = 0;
                $table->password = crypt($model->password, Yii::$app->params["salt"]);  //Encriptamos el password

                //Si el registro es guardado correctamente
                if ($table->insert())
                {
                    //Nueva consulta para obtener el id del usuario
                    //Para confirmar al usuario se requiere su id y su authKey
                    $user = $table->find()->where(["email" => $model->email])->one();
                    $id = urlencode($user->id);
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $authKey = substr(str_shuffle($permitted_chars), 0, 10);
            
                    $subject = "Confirmar registro";
                    $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                    $body .= "<a href='http://localhost/gitBruno/alertas/basic/web/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";
            
                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                    ->setTo($user->email)
                    ->setFrom('pruebaweb099@gmail.com')
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
            
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
                    $model->nick = null;
                    $model->nombre = null;
                    $model->apellidos = null;
            
                    $msg = "Enhorabuena, ahora sólo falta que confirmes tu registro en tu cuenta de correo";
                }
                else
                {
                    $msg = "Ha ocurrido un error al llevar a cabo tu registro";
                }
        
            }
            else
            {
                $model->getErrors();
            }
        }

        // CREAMOS LA INCIDENCIA DEL REGISTRO
        $incidencia = new UsuarioIncidencias();
        $incidencia->crea_fecha=date("Y-m-d H:m:s");
        $incidencia->clase_incidencia_id="N";
        $incidencia->texto="Nuevo usuario registrado";
        $incidencia->destino_usuario_id="0";
        $incidencia->origen_usuario_id=Yii::$app->user->id;
        $incidencia->insert();

        return $this->render("registrarse", ["model" => $model, "msg" => $msg]);
    }

    # =========================================================== #
    # FUNCION PREDEFINIDA DE BUSCAR 
    /*protected function findModel($id)
    {
        if (($model = Alertas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }*/
}

