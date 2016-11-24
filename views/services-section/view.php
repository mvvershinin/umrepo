<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\ServicesSection */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Администрирование', 'url' => ['site/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Специализации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="services-section-view">

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'section_name',
            'description',
            'picture',
            'sort',
            'color',
        ],
    ]) ?>

</div>
