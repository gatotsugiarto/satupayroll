<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\Formulir1721A1 $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="formulir1721-a1-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <?= $form->field($model, 'tahun_pajak')->textInput() ?>

    <?= $form->field($model, 'npwp_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_pegawai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'npwp_nik_pegawai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_ptkp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_pegawai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penghasilan_bruto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'biaya_jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'iuran_pensiun_jht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penghasilan_neto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pkp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_terutang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pph21_dipotong_perusahaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_pejabat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sign_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sign_image')->textInput(['maxlength' => true]) ?>

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
