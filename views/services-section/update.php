<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServicesSection */

$this->title = 'Изменить специализацию: ' . $model->section_name;
$this->params['breadcrumbs'][] = ['label' => 'Администрирование', 'url' => ['site/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Специализации', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->section_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-section-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
