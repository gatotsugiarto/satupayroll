<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollThr $model */

$this->title = 'Update Payroll Thr: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Thrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="payroll-thr-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
