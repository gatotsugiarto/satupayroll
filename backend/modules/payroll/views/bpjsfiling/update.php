<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BpjsFiling $model */

$this->title = 'Update Bpjs Filing: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bpjs Filings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bpjs-filing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
