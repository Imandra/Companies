<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компании'; ?>

<?php $this->params['breadcrumbs'][] = $this->title; ?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'contentOptions' => ['style' => 'width:10%;'],
            ],
            [
                'attribute' => 'TIN',
                'contentOptions' => ['style' => 'width:15%;'],
            ],
            [
                'attribute' => 'general_director',
                'contentOptions' => ['style' => 'width:15%;'],
            ],
            [
                'attribute' => 'address',
                'contentOptions' => ['style' => 'width:20%;'],
            ],
            [
                'header' => '',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a('Контакты',
                        ['/public-contact/index', 'PublicContactSearch[company_id]' => $data->id]
                    );
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
            ],
        ],
    ]); ?>
</div>
