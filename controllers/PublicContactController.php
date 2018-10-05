<?php

namespace app\controllers;

use app\models\Company;
use Yii;
use app\models\PublicContact;
use app\models\PublicContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PublicContactController implements the CRUD actions for PublicContact model.
 */
class PublicContactController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * Lists all PublicContact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublicContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $company = Company::findOne(Yii::$app->request->queryParams['PublicContactSearch']['company_id']);

        return $this->render('index', [
            'company' => $company,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the PublicContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PublicContact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PublicContact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
