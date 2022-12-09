<?php

namespace app\controllers;

use Yii;
use app\models\AlertaComentarios;
use app\models\AlertaComentariosSearch;
use app\models\UsuarioIncidencias;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlertaComentariosController implements the CRUD actions for AlertaComentarios model.
 */
class AlertaComentariosController extends Controller
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
     * Lists all AlertaComentarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AlertaComentariosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AlertaComentarios model.
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
     * Creates a new AlertaComentarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AlertaComentarios();

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
     * Updates an existing AlertaComentarios model.
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
     * Deletes an existing AlertaComentarios model.
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

    public function actionCrearcomentario($alerta_id)//quitarcomentaria
    {
        $model = new AlertaComentarios();
        $model->alerta_id=$alerta_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['site/comentarios', 'AlertaComentariosSearch[alerta_id]='=>$model->alerta_id]);//comrobar
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('crearcomentario', [
            'model' => $model,
        ]);
    }

    public function actionRespondercomentario($alerta_id,$id)//quitarcomentaria
    {
        $model = new AlertaComentarios();
        $model->alerta_id=$alerta_id;
        $model->comentario_id=$id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['site/comentarios', 'AlertaComentariosSearch[alerta_id]='=>$model->alerta_id]);//comrobar
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('crearcomentario', [
            'model' => $model,
        ]);
    }

    public function actionVistac($id)
    {
         return $this->render('vistac', [
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
               $incidencia->texto="Comentario denunciado";
               $incidencia->alerta_id=$id;
               $incidencia->destino_usuario_id="0";
               $incidencia->origen_usuario_id=Yii::$app->user->id;
               $incidencia->insert();

        return $this->redirect(['site/comentarios', 'AlertaComentariosSearch[alerta_id]='=>$model->alerta_id]);//comrobar
            //'searchModel' => $searchModel,
            //'dataProvider' => $dataProvider,
    }


    /**
     * Finds the AlertaComentarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AlertaComentarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AlertaComentarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
