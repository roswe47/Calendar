<?php

namespace app\controllers;

use app\models\Calendar;
use Yii;
use app\models\Access;
use app\models\search\CalendarSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class CalendarController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['mynotes', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['mynotes', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Calendar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search([
            'CalendarSearch'=>['creator' => Yii::$app->user->id]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'creator' => Yii::$app->user->id,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionMynotes()
    {
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search([
            'CalendarSearch'=>['creator' => Yii::$app->user->id]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFriendshedules($id){
        $searchModel = new CalendarSearch();
        $dataProvider = $searchModel->search([
           'CalendarSearch' => [
               'creator' => $id,
               'access' => [
                   'user_gest' => Yii::$app->user->id,
               ]
           ]
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $result = Access::checkAccess($model);
        switch($result){
            case Access::ACCESS_CREATOR:
                return $this->render('viewCreator', [
                    'model' => $model,
                ]);
            break;
            case Access::ACCESS_GUEST:
                return $this->render('viewGuest', [
                    'model' => $model,
                ]);
            break;
            default:
                throw new ForbiddenHttpException("Access denied", 403);
            break;
        }
    }

    /**
     * Creates a new Calendar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Calendar();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Calendar model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Calendar model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Calendar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Calendar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
