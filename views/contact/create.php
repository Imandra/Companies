<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Contact */

$this->title = 'Добавить контакт';
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['admin-company/index']];
$this->params['breadcrumbs'][] = ['label' => 'Контакты', 'url' => ['contact/index', 'ContactSearch[admin_company_id]' => $model->admin_company_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
