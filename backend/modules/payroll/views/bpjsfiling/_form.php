<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BpjsFiling $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="bpjs-filing-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->textInput() ?>

    <?= $form->field($model, 'month')->textInput() ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'period_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'basic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kes_perush')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kes_kary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_kes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jht_perush')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jht_kary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_jht')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jp_perush')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jp_kary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_jp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jkk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jkm')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_bayar')->textInput() ?>

    <?= $form->field($model, 'va')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bpi')->textInput(['maxlength' => true]) ?>

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
