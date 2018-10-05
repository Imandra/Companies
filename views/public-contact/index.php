<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PublicContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $company app\models\Company */

$this->title = 'Контакты компании "' . $company->name . '"';
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['company/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="public-contact-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'template' => '',
            ],
        ],
    ]); ?>
</div>
