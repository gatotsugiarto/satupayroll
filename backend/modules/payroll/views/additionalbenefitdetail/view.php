<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\AdditionalBenefitDetail $model */


$this->title = 'Detail '.'Additional Benefit Details';
$sub_title = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Additional Benefit Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="mb-3">
    <h5 class="text-primary fw-bold page-title">
        <i class="fa fa-building"></i>&nbsp;&nbsp;&nbsp;<?= $this->title ?>
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
                <span class="fw-semibold">
                    <?= Html::encode($model->employee_id) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Period code</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->period_code) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Item code</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->item_code) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Item name</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->item_name) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Category code</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->category_code) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Amount</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->amount) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Description</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->description) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Source</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->source) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Trace</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->trace) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Display order</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->display_order) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Generate mode</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->generate_mode) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Slip display</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->slip_display) ?>
                </span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Slip position</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->slip_position) ?>
                </span>
            </div>

            <div class="col-md-6">
                <span class="text-secondary small">Profile</span><br>
                <span class="fw-semibold">
                    <?= Html::encode($model->profile_id) ?>
                </span>
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
                <i class="far fa-clock"></i> <small><?=Html::encode($model->updated_at) ?></small>
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
