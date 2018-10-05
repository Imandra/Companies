<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $company app\models\AdminCompany */

$this->title = 'Контакты компании "' . $company->name . '"';

$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['admin-company/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="contact-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить контакт', ['create', 'admin_company_id'=>$company->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'phone_number',
            'email:email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>
</div>