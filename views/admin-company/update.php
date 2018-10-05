<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AdminCompany */

$this->title = 'Изменить компанию "' . $model->name . '"';

$this->params['breadcrumbs'][] = ['label' =>  'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="admin-company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
