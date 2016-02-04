<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Calendar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_event')->widget(\yii\jui\DatePicker::className(),
                                                                [
                                                                    'attribute'  => 'date_event',
                                                                    'value'  => 'date_event',
                                                                    'options' => [
                                                                        'placeholder' => 'Please, select a planned date ...',
                                                                        'todayHighlight' => true,
                                                                        //'template' => ,
                                                                        'class' => 'form-control'
                                                                    ],
                                                                    'language' => 'ru',
                                                                    'dateFormat' => 'yyyy-MM-dd',
                                                                ])?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <!--<?= $form->field($model, 'creator')->textInput() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
