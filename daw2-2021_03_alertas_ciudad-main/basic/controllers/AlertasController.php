<?php

namespace app\controllers;

use Yii;
use app\models\Alertas;
use app\models\AlertasSearch;
use app\models\UsuarioIncidencias;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlertasController implements the CRUD actions for Alertas model.
 */
class AlertasController extends Controller
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
     * Lists all Alertas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertasSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Alertas model.
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

    /**
     * Creates a new Alertas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alertas();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Alertas model.
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
     * Deletes an existing Alertas model.
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


    public function actionViewpublico($id)//quitar
    {
        return $this->render('viewpublico', [
            'model' => $this->findModel($id),
        ]);
    }


        public function actionEstado($id)//quitar
    {
         return $this->render('estado', [
            'model' => $this->findModel($id),
        ]);
            
        
    }

    
    public function actionDenuncia($id)
    {
        //$searchModel = new AlertasSearch();
        //$dataProvider = $searchModel->search($this->request->queryParams);

       $model = $this->findModel($id);
       $model->num_denuncias = $model->num_denuncias + 1;
       $model->save();

        // CREAMOS LA INCIDENCIA DEL REGISTRO
        $incidencia = new UsuarioIncidencias();
        $incidencia->crea_fecha=date("Y-m-d H:m:s");
        $incidencia->clase_incidencia_id="D";
        $incidencia->texto="Alerta denunciada";
        $incidencia->alerta_id=$id;
        $incidencia->destino_usuario_id="0";
        $incidencia->origen_usuario_id=Yii::$app->user->id;
        $incidencia->insert();

       return $this->render('estado', [
            'model' => $this->findModel($id),
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
        ]);
    }





    /**
     * Finds the Alertas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Alertas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alertas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
