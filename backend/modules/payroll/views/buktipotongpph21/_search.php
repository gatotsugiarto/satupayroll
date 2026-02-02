<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BuktiPotongPph21Search $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bukti-potong-pph21-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'masa_pajak') ?>

    <?= $form->field($model, 'tahun_pajak') ?>

    <?= $form->field($model, 'npwp_perusahaan') ?>

    <?= $form->field($model, 'nama_perusahaan') ?>

    <?php // echo $form->field($model, 'npwp_nik_pegawai') ?>

    <?php // echo $form->field($model, 'nama_pegawai') ?>

    <?php // echo $form->field($model, 'status_pegawai') ?>

    <?php // echo $form->field($model, 'kode_objek_pajak') ?>

    <?php // echo $form->field($model, 'status_ptkp') ?>

    <?php // echo $form->field($model, 'penghasilan_bruto') ?>

    <?php // echo $form->field($model, 'biaya_jabatan') ?>

    <?php // echo $form->field($model, 'iuran_pensiun_jht') ?>

    <?php // echo $form->field($model, 'penghasilan_neto') ?>

    <?php // echo $form->field($model, 'pph21_terutang') ?>

    <?php // echo $form->field($model, 'pph21_dipotong_karyawan') ?>

    <?php // echo $form->field($model, 'pph21_ditanggung_perusahaan') ?>

    <?php // echo $form->field($model, 'skema_pajak') ?>

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
