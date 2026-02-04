<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollThr $model */

$this->title = 'Create Payroll Thr';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Thrs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-thr-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
