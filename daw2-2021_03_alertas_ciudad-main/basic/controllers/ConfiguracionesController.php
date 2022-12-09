<?php

namespace app\controllers;

use app\models\Configuraciones;
use app\models\ConfiguracionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfiguracionesController implements the CRUD actions for Configuraciones model.
 */
class ConfiguracionesController extends Controller
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
     * Lists all Configuraciones models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfiguracionesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Configuraciones model.
     * @param string $variable Variable
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($variable)
    {
        return $this->render('view', [
            'model' => $this->findModel($variable),
        ]);
    }

    /**
     * Creates a new Configuraciones model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Configuraciones();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'variable' => $model->variable]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Configuraciones model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $variable Variable
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($variable)
    {
        $model = $this->findModel($variable);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'variable' => $model->variable]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Configuraciones model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $variable Variable
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($variable)
    {
        $this->findModel($variable)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Configuraciones model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $variable Variable
     * @return Configuraciones the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($variable)
    {
        if (($model = Configuraciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
