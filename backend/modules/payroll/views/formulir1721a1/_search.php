<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\Formulir1721A1Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="formulir1721-a1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'tahun_pajak') ?>

    <?= $form->field($model, 'npwp_perusahaan') ?>

    <?= $form->field($model, 'nama_perusahaan') ?>

    <?php // echo $form->field($model, 'alamat_perusahaan') ?>

    <?php // echo $form->field($model, 'nama_pegawai') ?>

    <?php // echo $form->field($model, 'npwp_nik_pegawai') ?>

    <?php // echo $form->field($model, 'status_ptkp') ?>

    <?php // echo $form->field($model, 'alamat_pegawai') ?>

    <?php // echo $form->field($model, 'penghasilan_bruto') ?>

    <?php // echo $form->field($model, 'biaya_jabatan') ?>

    <?php // echo $form->field($model, 'iuran_pensiun_jht') ?>

    <?php // echo $form->field($model, 'penghasilan_neto') ?>

    <?php // echo $form->field($model, 'pkp') ?>

    <?php // echo $form->field($model, 'pph21_terutang') ?>

    <?php // echo $form->field($model, 'pph21_dipotong_perusahaan') ?>

    <?php // echo $form->field($model, 'nama_pejabat') ?>

    <?php // echo $form->field($model, 'sign_name') ?>

    <?php // echo $form->field($model, 'sign_image') ?>

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
