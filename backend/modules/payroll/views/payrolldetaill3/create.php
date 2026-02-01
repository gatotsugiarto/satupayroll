<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollDetailL3 $model */

$this->title = 'Create Payroll Detail L3';
$this->params['breadcrumbs'][] = ['label' => 'Payroll Detail L3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payroll-detail-l3-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
