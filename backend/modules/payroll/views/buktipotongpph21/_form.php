<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BuktiPotongPph21 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bukti-potong-pph21-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'masa_pajak')->textInput() ?>

    <?= $form->field($model, 'tahun_pajak')->textInput() ?>

    <?= $form->field($model, 'npwp_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'npwp_nik_pegawai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_pegawai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_pegawai')->dropDownList([ 'TETAP' => 'TETAP', 'TIDAK_TETAP' => 'TIDAK TETAP', 'BUKAN_PEGAWAI' => 'BUKAN PEGAWAI', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'kode_objek_pajak')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_ptkp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penghasilan_bruto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biaya_jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iuran_pensiun_jht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penghasilan_neto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_terutang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_dipotong_karyawan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_ditanggung_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'skema_pajak')->dropDownList([ 'NET' => 'NET', 'GROSS' => 'GROSS', 'GROSS-UP' => 'GROSS-UP', ], ['prompt' => '']) ?>

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
