<?php
use yii\helpers\Html;
?>

<div class="mb-3">
    <h5 class="text-primary fw-bold page-title">
        <i class="fa fa-building"></i>&nbsp;&nbsp;&nbsp;Detail Payroll Component
    </h5>
    <p class="text-muted small mb-0">
        Configure salary components used in payroll calculations
    </p>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Component: <strong><?= Html::encode($model->name) ?></strong></span><br>
                <span class="fw-semibold"><small>Code: <?= Html::encode($model->code) ?></small></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Payroll Category</span><br>
                <span class="fw-semibold"><?= Html::encode($model->category->name) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Type</span><br>
                <span class="fw-semibold"><?= Html::encode($model->type) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Sign</span><br>
                <span class="fw-semibold"><?= Html::encode($model->sign) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Affects Gross Tax</span><br>
                <span class="fw-semibold"><?= Html::encode($model->affects_gross_tax) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Taxable</span><br>
                <span class="fw-semibold"><?= Html::encode($model->taxable) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Display Orders</span><br>
                <span class="fw-semibold"><?= Html::encode($model->display_order) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Percentage</span><br>
                <span class="fw-semibold"><?= Html::encode($model->percent) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">CAP</span><br>
                <span class="fw-semibold"><?= Html::encode($model->cap) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Salary Type</span><br>
                <span class="fw-semibold"><?= Html::encode($model->salary_type) ?></span>
            </div>
        </div>

        <?php
        $monthly_exec = $model->monthly_exec ? $model->monthly_exec : '-';
        ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Status</span><br>
                <span class="fw-semibold"><?= Html::encode($model->status->status_active ) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Month Execute</span><br>
                <span class="fw-semibold"><?= Html::encode($monthly_exec ) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Component Code</span><br>
                <span class="fw-semibold"><?= Html::encode($model->item_code) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Base Multiplier</span><br>
                <span class="fw-semibold"><?= Html::encode($model->base_multiplier) ?></span>
            </div>
        </div>
        
        <hr class="my-2">

        <div class="row mb-2 small">
            <div class="col-md-6 text-muted">
                <i class="fa fa-plus-circle"></i> Created by:
                <strong><?= Html::encode($model->createdBy->fullname) ?></strong>
                <br>
                <i class="far fa-clock"></i> <small><?= Html::encode($model->created_at) ?></small>
            </div>
            <div class="col-md-6 text-muted">
                <i class="fa fa-edit"></i> Updated by:
                <strong><?= Html::encode($model->updatedBy->fullname) ?></strong>
                <br>
                <i class="far fa-clock"></i> <small><?= Html::encode($model->updated_at) ?></small>
            </div>
        </div>

        

    </div>
</div>

<div class="text-end mt-3">
    <?= Html::button('<i class="fa fa-times"></i> Close', [
        'class' => 'btn btn-outline-secondary',
        'data-dismiss' => 'modal',
        'style' => 'min-width:140px;',
    ]) ?>
</div>
