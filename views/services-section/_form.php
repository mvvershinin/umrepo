<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\ColorInput;

/* @var $this yii\web\View */
/* @var $model app\models\ServicesSection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="services-section-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'section_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    
    <?php
        if(isset($model->picture) && file_exists(Yii::getAlias('@webroot', $model->picture)))
           {echo Html::img('@web/images/' . $model->picture, ['class'=>'img-responsive']);}
    ?>
    <?= $form->field($model, 'picture')->fileInput()->label('') ?>
    
    <?= $form->field($model, 'sort')->textInput() ?>
    
    <?= $form->field($model, 'color')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select Color...'],]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
