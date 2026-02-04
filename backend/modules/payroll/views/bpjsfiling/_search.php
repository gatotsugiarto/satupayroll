<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BpjsFilingSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bpjs-filing-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'month') ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'period_code') ?>

    <?php // echo $form->field($model, 'basic') ?>

    <?php // echo $form->field($model, 'kes_perush') ?>

    <?php // echo $form->field($model, 'kes_kary') ?>

    <?php // echo $form->field($model, 'total_kes') ?>

    <?php // echo $form->field($model, 'jht_perush') ?>

    <?php // echo $form->field($model, 'jht_kary') ?>

    <?php // echo $form->field($model, 'total_jht') ?>

    <?php // echo $form->field($model, 'jp_perush') ?>

    <?php // echo $form->field($model, 'jp_kary') ?>

    <?php // echo $form->field($model, 'total_jp') ?>

    <?php // echo $form->field($model, 'jkk') ?>

    <?php // echo $form->field($model, 'jkm') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'tanggal_bayar') ?>

    <?php // echo $form->field($model, 'va') ?>

    <?php // echo $form->field($model, 'bpi') ?>

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
