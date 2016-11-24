<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ServiceSpec */

$this->title = 'Create Service Spec';
$this->params['breadcrumbs'][] = ['label' => 'Service Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'services' => $services,
    ]) ?>

</div>
