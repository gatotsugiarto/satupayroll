<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;

$isNew = $model->isNewRecord;
$title = $isNew ? 'Batch Process' : 'Edit Payroll';
$icon = $isNew ? 'fa-user-plus' : 'fa-edit';
?>

<div class="modal-header bg-default text-white rounded-top-4">
    <div>
        <h5 class="text-primary fw-bold page-title mb-1">
            <i class="fa <?= $icon ?> mr-2"></i> <?= $title ?>
        </h5>
        <small class="text-muted">
            <?= $isNew
                ? 'Please fill in the year and month period form below to process a new THR.'
                : 'Update salary information below.' ?>
        </small>
    </div>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'salary-form',
    'enableAjaxValidation' => false,
    // 'validationUrl' => ['salary/validate'],
    'action' => $isNew ? ['payrollthr/batch'] : ['payrollthr/update', 'id' => $model->id],
    'options' => ['data-pjax' => 0],
]); ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="modal-body px-4 pb-4">
        
        <?= Html::hiddenInput('form_token', $formToken) ?>
        <?= $form->field($model, 'employee_id')->HiddenInput()->label(false) ?>

        <?php
        if($model->isNewRecord){
            $model->month = date('m');
            $model->year = date('Y');
        }
        ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'year')->widget(Select2::classname(), [
                    'data' => \common\modules\master\models\Year::dropdown(),
                    'options' => [
                        'placeholder' => 'Year',
                        // 'id' => 'employee_id',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        // 'dropdownParent' => new \yii\web\JsExpression('$("#appModal")'), // pastikan ID sesuai modal
                        // 'escapeMarkup' => new \yii\web\JsExpression('function (m) { return m; }'),
                    ],
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'month')->widget(Select2::classname(), [
                    'data' => \common\modules\master\models\Month::dropdown(),
                    'options' => [
                        'placeholder' => 'Month',
                        // 'id' => 'employee_id',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        // 'dropdownParent' => new \yii\web\JsExpression('$("#appModal")'), // pastikan ID sesuai modal
                        // 'escapeMarkup' => new \yii\web\JsExpression('function (m) { return m; }'),
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
        <?= Html::submitButton('<i class="fa fa-save"></i> Process', [
            'class' => 'btn btn-primary px-4',
            'style' => 'min-width:140px;',
        ]) ?>
    </div>

</div>


<?php ActiveForm::end(); ?>
    
