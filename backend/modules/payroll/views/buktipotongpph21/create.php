<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BuktiPotongPph21 $model */

$this->title = 'Create Bukti Potong Pph21';
$this->params['breadcrumbs'][] = ['label' => 'Bukti Potong Pph21s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bukti-potong-pph21-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
