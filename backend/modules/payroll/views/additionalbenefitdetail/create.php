<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\AdditionalBenefitDetail $model */

$this->title = 'Create Additional Benefit Detail';
$this->params['breadcrumbs'][] = ['label' => 'Additional Benefit Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="additional-benefit-detail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
