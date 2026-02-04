<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollThrSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="payroll-thr-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'month') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'period_code') ?>

    <?php // echo $form->field($model, 'gross') ?>

    <?php // echo $form->field($model, 'thp') ?>

    <?php // echo $form->field($model, 'thr_accrual') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'approved_at') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
