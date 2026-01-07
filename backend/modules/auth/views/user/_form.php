<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$isNew = $model->isNewRecord;
$title = $isNew ? 'Create New User' : 'Edit User';
$icon = $isNew ? 'fa-user-plus' : 'fa-edit';
?>

<div class="modal-header bg-default text-white rounded-top-4">
    <div>
        <h5 class="text-primary fw-bold page-title mb-1">
            <i class="fa <?= $icon ?> mr-2"></i> <?= $title ?>
        </h5>
        <small class="text-muted">
            <?= $isNew
                ? 'Please fill in the form below to register a new user.'
                : 'Update user information below.' ?>
        </small>
    </div>
</div>

<?php $form = ActiveForm::begin([
    'id' => 'user-form',
    'enableAjaxValidation' => true,
    'validationUrl' => ['user/validate'],
    'action' => $isNew ? ['user/create'] : ['user/update', 'id' => $model->id],
    'options' => ['data-pjax' => 0],
]); ?>

<div class="card shadow-sm border-0 rounded-4">
    <div class="modal-body px-4 pb-4">
        
        <?= Html::hiddenInput('form_token', $formToken) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'fullname')->textInput() ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md-6">
                <?php if ($isNew): ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                <?php else: ?>
                    <?= $form->field($model, 'password')->hiddenInput()->label(false) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="d-flex justify-content-end gap-2 mt-3">
    <?= Html::button('<i class="fa fa-times"></i> Cancel', [
        'class' => 'btn btn-outline-secondary mr-2 px-4',
        'data-dismiss' => 'modal',
        'style' => 'min-width:140px;',
    ]) ?>

    <?= Html::submitButton('<i class="fa fa-save"></i> Save', [
        'class' => 'btn btn-primary px-4',
        'style' => 'min-width:140px;',
    ]) ?>
</div>

<?php ActiveForm::end(); ?>
    
