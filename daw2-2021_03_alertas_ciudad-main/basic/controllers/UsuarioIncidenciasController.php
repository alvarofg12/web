<?php

namespace app\controllers;

use Yii;
use app\models\UsuarioIncidencias;
use app\models\UsuarioIncidenciasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsuarioIncidenciasController implements the CRUD actions for UsuarioIncidencias model.
 */
class UsuarioIncidenciasController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all UsuarioIncidencias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioIncidenciasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuarioIncidencias model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

        public function actionViewpublico($id)
    {
        return $this->render('viewpublico', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UsuarioIncidencias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsuarioIncidencias();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $model->crea_fecha=date("Y-m-d H:m:s");

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //create publico 
    public function actionCreatepublico()
    {
        $model = new UsuarioIncidencias();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['viewpublico', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $model->crea_fecha=date("Y-m-d H:m:s");
        $model->origen_usuario_id=Yii::$app->user->id;
        return $this->render('createpublico', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UsuarioIncidencias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UsuarioIncidencias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /*
      Acción de responder a una incidencia
        se responderá con otra incidencia en la que no se puedan cambiar ni origen ni destino
        dependiendo de a quien respondas
    */

    public function actionAnswer($id)
    {
        $modelbase = $this->findModel($id);
        $model = new UsuarioIncidencias();
/*
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['create', 'id' => $model->id]);
        }
*/
        //Yii::$app->user->id -> sacamos el id de la sesión 
        

        //$model->id=null; 
        $model->crea_fecha=date("Y-m-d H:m:s");
        $model->texto=null;
        $model->clase_incidencia_id="R";  //cuando sea una respuesta, que el tipo sea siempre R
        $aux=$modelbase->origen_usuario_id;  //guardamos el valor en auxiliar
        $model->origen_usuario_id=$modelbase->destino_usuario_id;
        $model->alerta_id=$modelbase->alerta_id; 
        $model->comentario_id=$modelbase->comentario_id; 
         // el base tiene los datos del modelo que estamos respondiendo y el model no tiene ninguno, pasamos solo lo que queremos
        $model->destino_usuario_id=$aux;
        
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Finds the UsuarioIncidencias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UsuarioIncidencias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioIncidencias::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
