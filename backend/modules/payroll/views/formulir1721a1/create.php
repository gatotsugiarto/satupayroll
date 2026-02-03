<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\Formulir1721A1 $model */

$this->title = 'Create Formulir1721a1';
$this->params['breadcrumbs'][] = ['label' => 'Formulir1721a1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formulir1721-a1-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
