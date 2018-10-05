<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AdminCompany */

$this->title = 'Добавить компанию';
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
