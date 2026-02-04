<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BpjsFiling $model */

$this->title = 'Create Bpjs Filing';
$this->params['breadcrumbs'][] = ['label' => 'Bpjs Filings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bpjs-filing-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
