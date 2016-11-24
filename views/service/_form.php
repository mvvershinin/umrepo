<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\models\Service */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'section')->dropDownList(
  		ArrayHelper::map($section, 'id', 'section_name'),
		['prompt' => 'Специализация...']
	) ?>

    <?= $form->field($model, 'serv_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?php
        if(($model->picture) && file_exists(Yii::getAlias('@webroot/images/', $model->picture))) //@webroot
           {echo Html::img('@web/images/' . $model->picture, ['class'=>'img-responsive']);}
    ?>
    <?= $form->field($model, 'picture')->fileInput()->label('') ?>

    <?= $form->field($model, 'color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select Color...'],]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
