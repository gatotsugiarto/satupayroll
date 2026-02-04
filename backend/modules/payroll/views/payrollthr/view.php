<?php
use yii\helpers\Html;

$this->title = "Detail THR";
$sub_title = "Employee payroll processing results.";
?>

<div class="mb-3">
    <h5 class="text-primary fw-bold page-title">
        <i class="fa fa-building"></i>&nbsp;&nbsp;&nbsp;<?=$this->title ?>
    </h5>
    <p class="text-muted small mb-0">
        <?=$sub_title ?>
    </p>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Employee</span><br>
                <span class="fw-semibold"><?= Html::encode($model->employee->fullname) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">THR Period</span><br>
                <span class="fw-semibold"><?= Html::encode($model->period_code) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Gross</span><br>
                <span class="fw-semibold">Rp. <?= number_format($model->gross, 2, ',', '.')?>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">THR Accrual</span><br>
                <span class="fw-semibold">Rp. <?= number_format($model->thr_accrual, 2, ',', '.')?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Status</span><br>
                <span class="fw-semibold"><?= Html::encode($model->status->status_payroll) ?></span>
            </div>
            <div class="col-md-6">
                <!-- <span class="text-secondary small">THP</span><br>
                <span class="fw-semibold">Rp. <?= number_format($model->thp, 2, ',', '.')?>
                </span> -->
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
<?php if (Yii::$app->request->isAjax): ?>

    <?= Html::button('<i class="fa fa-times"></i> Close', [
        'class' => 'btn btn-outline-secondary',
        'data-dismiss' => 'modal',
        'style' => 'min-width:140px;',
    ]) ?>

<?php else: ?>

    <?= Html::a('<i class="fa fa-arrow-left"></i> Back', 'javascript:history.back()', [
        'class' => 'btn btn-outline-secondary',
        'style' => 'min-width:140px;',
    ]) ?>

<?php endif; ?>
</div>
