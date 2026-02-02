<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BuktiPotongPph21 $model */

$this->title = 'Update Bukti Potong Pph21: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bukti Potong Pph21s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bukti-potong-pph21-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
