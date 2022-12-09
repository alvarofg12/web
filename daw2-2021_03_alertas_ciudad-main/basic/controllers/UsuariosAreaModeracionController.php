<?php

namespace app\controllers;

use app\models\UsuariosAreaModeracion;
use app\models\Areas;
use app\models\Usuarios;
use app\models\UsuariosAreaModeracionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * UsuariosAreaModeracionController implements the CRUD actions for UsuariosAreaModeracion model.
 */
class UsuariosAreaModeracionController extends Controller
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
     * Lists all UsuariosAreaModeracion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuariosAreaModeracionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuariosAreaModeracion model.
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
     * Creates a new UsuariosAreaModeracion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UsuariosAreaModeracion();
        $lista_areas= Areas::find()->all();
        $areas=ArrayHelper::map($lista_areas,'id','nombre');

        $lista_usuarios= Usuarios::find()->all();
        $usuarios=ArrayHelper::map($lista_usuarios,'id','nick');


        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'usuarios' => $usuarios,
            'areas' => $areas,
        ]);
    }

    /**
     * Updates an existing UsuariosAreaModeracion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $lista_areas= Areas::find()->all();
        $areas=ArrayHelper::map($lista_areas,'id','nombre');

        $lista_usuarios= Usuarios::find()->all();
        $usuarios=ArrayHelper::map($lista_usuarios,'id','nick');


        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'usuarios' => $usuarios,
            'areas' => $areas,
        ]);
    }

    /**
     * Deletes an existing UsuariosAreaModeracion model.
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

    /**
     * Finds the UsuariosAreaModeracion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return UsuariosAreaModeracion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuariosAreaModeracion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
