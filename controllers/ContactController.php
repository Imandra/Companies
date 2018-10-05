<?php

namespace app\controllers;

use app\models\AdminCompany;
use Yii;
use app\models\Contact;
use app\models\ContactSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\components\AccessRule;
use app\models\User;
use yii\filters\AccessControl;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_EDITOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_EDITOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_EDITOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_EDITOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],

        ];
    }

    /**
     * Lists all Contact models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $company = AdminCompany::findOne(Yii::$app->request->queryParams['ContactSearch']['admin_company_id']);

        return $this->render('index', [
            'company' => $company,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contact model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }*/

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param  integer $admin_company_id
     * @return mixed
     */
    public function actionCreate($admin_company_id)
    {
        $model = new Contact();
        $model->admin_company_id = $admin_company_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $adminCompany = $model->adminCompany;
            $adminCompany->status != 'Создана' ? $adminCompany->status = 'Изменена' : $adminCompany->status = 'Создана';
            $adminCompany->save(false);
            Yii::$app->session->setFlash('success', 'Контакт "' . $model->name . '" успешно добавлен.');
            return $this->redirect(['index', 'ContactSearch[admin_company_id]' => $model->admin_company_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $adminCompany = $model->adminCompany;
            $adminCompany->status != 'Создана' ? $adminCompany->status = 'Изменена' : $adminCompany->status = 'Создана';
            $adminCompany->save(false);
            Yii::$app->session->setFlash('success', 'Контакт "' . $model->name . '" успешно изменен.');
            return $this->redirect(['index', 'ContactSearch[admin_company_id]' => $model->admin_company_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->delete()) {
            $adminCompany = $model->adminCompany;
            $adminCompany->status != 'Создана' ? $adminCompany->status = 'Изменена' : $adminCompany->status = 'Создана';
            $adminCompany->save(false);
            Yii::$app->session->setFlash('success', 'Контакт "' . $model->name . '" успешно удален.');
        };

        return $this->redirect(['index', 'ContactSearch[admin_company_id]' => $model->admin_company_id]);
    }

    /**
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
