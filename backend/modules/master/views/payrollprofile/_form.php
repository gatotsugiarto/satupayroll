<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;

$isNew = $model->isNewRecord;
$title = $isNew ? 'Create New Payroll Profile' : 'Edit Payroll Profile';
$icon = $isNew ? 'fa-user-plus' : 'fa-edit';
?>

<div class="modal-header bg-default text-white rounded-top-4">
    <div>
        <h5 class="text-primary fw-bold page-title mb-1">
            <i class="fa <?= $icon ?> mr-2"></i> <?= $title ?>
        </h5>
        <small class="text-muted">
            <?= $isNew
                ? 'Please fill in the form below to register a new payroll profile.'
                : 'Update payroll profile information below.' ?>
        </small>
    </div>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'payroll-profile-form',
    'enableAjaxValidation' => false,
    // 'validationUrl' => ['payrollprofile/validate'],
    'action' => $isNew ? ['payrollprofile/create'] : ['payrollprofile/update', 'id' => $model->id],
    'options' => ['data-pjax' => 0],
]); ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="modal-body px-4 pb-4">
        
        <?= Html::hiddenInput('form_token', $formToken) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'profile_name')->textInput([
                    'placeholder' => 'Enter Profile Name',
                    'class' => 'form-control form-control-custom'
                ]) ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'payroll_mode')->widget(Select2::class, [
                    'data' => ['GROSS' => 'GROSS', 'GROSS_UP' => 'GROSS UP'],
                    'options' => [
                        'placeholder' => 'Profile Mode',
                        'class' => 'select2-custom'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new \yii\web\JsExpression('$("#appModal")')
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?php if ($isNew): ?>
                    <?= $form->field($model, 'status_id')->hiddenInput(['value' => 1])->label(false) ?>
                <?php else: ?>
                    <?= $form->field($model, 'status_id')->widget(Select2::class, [
                        'data' => common\modules\master\models\StatusActive::dropdown(),
                        'options' => [
                            'placeholder' => 'Select status...',
                            'class' => 'select2-custom'
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'dropdownParent' => new \yii\web\JsExpression('$("#appModal")')
                        ],
                    ]) ?>
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <?= $form->field($model, 'is_default')->widget(Select2::class, [
                    'data' => ['1' => 'Default', '0' => 'No'],
                    'options' => [
                        'placeholder' => 'Profile Mode',
                        'class' => 'select2-custom'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'dropdownParent' => new \yii\web\JsExpression('$("#appModal")')
                    ],
                ]) ?>
            </div>
        </div>

    </div>
</div>

<div class="d-flex justify-content-between align-items-center mt-3">

    <!-- LEFT: Back / Close -->
    <div>
        <?php if (Yii::$app->request->isAjax): ?>

            <?= Html::button('<i class="fa fa-times"></i> Close', [
                'class' => 'btn btn-outline-secondary px-4',
                'data-dismiss' => 'modal',
                'style' => 'min-width:140px;',
            ]) ?>

        <?php else: ?>

            <?= Html::a('<i class="fa fa-arrow-left"></i> Back', 'javascript:history.back()', [
                'class' => 'btn btn-outline-secondary px-4',
                'style' => 'min-width:140px;',
            ]) ?>

        <?php endif; ?>
    </div>

    <!-- RIGHT: Submit -->
    <div>
        <?= Html::submitButton('<i class="fa fa-save"></i> Save', [
            'class' => 'btn btn-primary px-4',
            'style' => 'min-width:140px;',
        ]) ?>
    </div>

</div>


<?php ActiveForm::end(); ?>
    
