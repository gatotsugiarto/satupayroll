<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollDetailL3 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="payroll-detail-l3-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <?= $form->field($model, 'period_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payroll_mode')->dropDownList([ 'GROSS' => 'GROSS', 'NET' => 'NET', 'GROSS_UP' => 'GROSS UP', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'generate_mode')->dropDownList([ 'Batch' => 'Batch', 'Single' => 'Single', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'basic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ops_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fixed_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'overtime_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'accodtn_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'so_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ig_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doublepos_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'misc_allow')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'var_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actual_salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jht_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jp_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jkm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jkk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bpjs_kes_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employer_bpjs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bonus')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tunj_keseh')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lembur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rev_absensi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tunj_pph21')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cut_unpaid')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cut_absensi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cut_alpha')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'other_income')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bruto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employer_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bruto_tax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ter')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ter_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_dec_net')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bruto_tax_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biaya_jabatan_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jp_jht_kary_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ptkp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pkp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'neto_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_year')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_jan_nov')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_net_employer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jht_kary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jp_kary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bpjs_kes_kary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ded_misc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_potongan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
