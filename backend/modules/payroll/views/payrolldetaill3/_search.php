<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollDetailL3Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="payroll-detail-l3-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'period_code') ?>

    <?= $form->field($model, 'payroll_mode') ?>

    <?= $form->field($model, 'generate_mode') ?>

    <?php // echo $form->field($model, 'basic') ?>

    <?php // echo $form->field($model, 'position_allow') ?>

    <?php // echo $form->field($model, 'ops_allow') ?>

    <?php // echo $form->field($model, 'fixed_income') ?>

    <?php // echo $form->field($model, 'overtime_allow') ?>

    <?php // echo $form->field($model, 'accodtn_allow') ?>

    <?php // echo $form->field($model, 'so_allow') ?>

    <?php // echo $form->field($model, 'ig_allow') ?>

    <?php // echo $form->field($model, 'doublepos_allow') ?>

    <?php // echo $form->field($model, 'misc_allow') ?>

    <?php // echo $form->field($model, 'var_income') ?>

    <?php // echo $form->field($model, 'actual_salary') ?>

    <?php // echo $form->field($model, 'jht_perusahaan') ?>

    <?php // echo $form->field($model, 'jp_perusahaan') ?>

    <?php // echo $form->field($model, 'jkm') ?>

    <?php // echo $form->field($model, 'jkk') ?>

    <?php // echo $form->field($model, 'bpjs_kes_perusahaan') ?>

    <?php // echo $form->field($model, 'employer_bpjs') ?>

    <?php // echo $form->field($model, 'thr') ?>

    <?php // echo $form->field($model, 'bonus') ?>

    <?php // echo $form->field($model, 'tunj_keseh') ?>

    <?php // echo $form->field($model, 'lembur') ?>

    <?php // echo $form->field($model, 'rev_absensi') ?>

    <?php // echo $form->field($model, 'tunj_pph21') ?>

    <?php // echo $form->field($model, 'cut_unpaid') ?>

    <?php // echo $form->field($model, 'cut_absensi') ?>

    <?php // echo $form->field($model, 'cut_alpha') ?>

    <?php // echo $form->field($model, 'other_income') ?>

    <?php // echo $form->field($model, 'bruto') ?>

    <?php // echo $form->field($model, 'employer_cost') ?>

    <?php // echo $form->field($model, 'bruto_tax') ?>

    <?php // echo $form->field($model, 'ter') ?>

    <?php // echo $form->field($model, 'ter_rate') ?>

    <?php // echo $form->field($model, 'pph21_dec_net') ?>

    <?php // echo $form->field($model, 'bruto_tax_year') ?>

    <?php // echo $form->field($model, 'biaya_jabatan_year') ?>

    <?php // echo $form->field($model, 'jp_jht_kary_year') ?>

    <?php // echo $form->field($model, 'ptkp') ?>

    <?php // echo $form->field($model, 'pkp') ?>

    <?php // echo $form->field($model, 'neto_year') ?>

    <?php // echo $form->field($model, 'pph21_year') ?>

    <?php // echo $form->field($model, 'pph21_jan_nov') ?>

    <?php // echo $form->field($model, 'pph21_net_employer') ?>

    <?php // echo $form->field($model, 'pph21') ?>

    <?php // echo $form->field($model, 'jht_kary') ?>

    <?php // echo $form->field($model, 'jp_kary') ?>

    <?php // echo $form->field($model, 'bpjs_kes_kary') ?>

    <?php // echo $form->field($model, 'ded_misc') ?>

    <?php // echo $form->field($model, 'total_potongan') ?>

    <?php // echo $form->field($model, 'thp') ?>

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
