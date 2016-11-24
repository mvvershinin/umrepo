<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ServiceSpec */

$this->title = 'Update Service Spec: ' . $model->spec_name;
$this->params['breadcrumbs'][] = ['label' => 'Service Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->spec_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="service-spec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'services' => $services,
    ]) ?>

</div>
