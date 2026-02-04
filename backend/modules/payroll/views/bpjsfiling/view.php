<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\BpjsFiling $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bpjs Filings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="bpjs-filing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'employee_id',
            'month',
            'year',
            'period_code',
            'basic',
            'kes_perush',
            'kes_kary',
            'total_kes',
            'jht_perush',
            'jht_kary',
            'total_jht',
            'jp_perush',
            'jp_kary',
            'total_jp',
            'jkk',
            'jkm',
            'total',
            'tanggal_bayar',
            'va',
            'bpi',
            'status_id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
