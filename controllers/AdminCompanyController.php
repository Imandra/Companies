<?php

namespace app\controllers;

use app\models\AdminCompanySearch;
use app\models\Contact;
use app\models\ContactSearch;
use app\models\PublicContact;
use Yii;
use app\models\AdminCompany;
use app\models\Company;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\components\AccessRule;
use app\models\User;
use yii\filters\AccessControl;

/**
 * AdminCompanyController implements the CRUD actions for AdminCompany model.
 */
class AdminCompanyController extends Controller
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
                    'approve' => ['POST'],
                    'reject' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                // We will override the default rule config with the new AccessRule class
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['index', 'create', 'update', 'delete', 'view', 'approve', 'reject'],
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
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_EDITOR,
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['approve'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                    [
                        'actions' => ['reject'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionApprove($id)
    {
        $model = $this->findModel($id);
        // TODO статусы заменить на int и сделать справочник в БД, dropdownlist во вью в поиске
        $model->status = 'Утверждена';
        // TODO это копирование реализовать через события
        if (Yii::$app->request->post() && $model->save()) {
           $company = Company::find()
               ->where(['admin_company_id' => $model->id])
               ->one();
            $company = $company ? $company : new Company();
            $company->name = $model->name;
            $company->TIN = $model->TIN;
            $company->general_director = $model->general_director;
            $company->address = $model->address;
            $company->admin_company_id = $model->id;

            if ($company->save()) {

                foreach ($model->contacts as $contact) {
                    $publicContact = PublicContact::find()
                        ->where(['contact_id' => $contact->id])
                        ->one();
                    $publicContact = $publicContact ? $publicContact : new PublicContact();
                    $publicContact->name = $contact->name;
                    $publicContact->phone_number = $contact->phone_number;
                    $publicContact->email = $contact->email;
                    $publicContact->company_id = $company->id;
                    $publicContact->contact_id = $contact->id;
                    $publicContact->save(false);
                }

                Yii::$app->session->setFlash('success', 'Компания "' . $model->name . '" успешно утверждена.');
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->status = 'Отклонена';

        if (Yii::$app->request->post() && $model->save()) {
            Yii::$app->session->setFlash('success', 'Компания "' . $model->name . '" успешно отклонена.');
        }

        return $this->redirect(['index']);
    }

    /**
     * Lists all AdminCompany models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single AdminCompany model.
     * @param integer $id
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
     * Creates a new AdminCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdminCompany();
        $model->status = 'Создана';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Компания "' . $model->name . '" успешно добавлена.');
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdminCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->status != 'Создана' ? $model->status = 'Изменена' : $model->status = 'Создана';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Компания "' . $model->name . '" успешно изменена.');
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AdminCompany model.
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
            Yii::$app->session->setFlash('success', 'Компания "' . $model->name . '" успешно удалена.');
        };

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdminCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
