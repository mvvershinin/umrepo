<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ServicesSection */

$this->title = 'Добавить специализацию';
$this->params['breadcrumbs'][] = ['label' => 'Администрирование', 'url' => ['site/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Специализации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-section-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
