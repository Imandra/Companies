<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Компании (администрирование)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить компанию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'name',
                'contentOptions' =>['style'=>'width:10%;'],
            ],
            [
                'attribute'=>'TIN',
                'contentOptions' =>['style'=>'width:15%;'],
            ],
            [
                'attribute'=>'general_director',
                'contentOptions' =>['style'=>'width:15%;'],
            ],
            [
                'attribute'=>'address',
                'contentOptions' =>['style'=>'width:20%;'],
            ],
            [
                'attribute'=>'status',
                'contentOptions' =>['style'=>'width:10%;'],
            ],

            [
                'header' => '',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a('Контакты',
                        ['/contact/index', 'ContactSearch[admin_company_id]' => $data->id]
                    );
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => (Yii::$app->user->identity->role == 'admin') ? '{view} {update} {delete}' : '{view} {update}',
            ],
            [
                'header' => '',
                'format' => 'raw',
                'value' => function ($data) {
                    return (($data->status == 'Создана' || $data->status == 'Изменена') && Yii::$app->user->identity->role == 'admin') ?
                        Html::a(
                            'Утвердить',
                            ['/admin-company/approve', 'id' => $data->id],
                            [
                                'class' => 'btn btn-success btn-xs',
                                'data-method' => 'POST',
                            ]
                        ) .  '<br><br>' .
                        Html::a(
                            'Отклонить',
                            ['/admin-company/reject', 'id' => $data->id],
                            [
                                'class' => 'btn btn-danger btn-xs',
                                'data-method' => 'POST',
                            ]
                        ) : '';
                }
            ],

        ],
    ]); ?>
</div>
