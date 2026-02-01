<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\modules\payroll\models\PayrollDetailL3 $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Payroll Detail L3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payroll-detail-l3-view">

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
            'period_code',
            'payroll_mode',
            'generate_mode',
            'basic',
            'position_allow',
            'ops_allow',
            'fixed_income',
            'overtime_allow',
            'accodtn_allow',
            'so_allow',
            'ig_allow',
            'doublepos_allow',
            'misc_allow',
            'var_income',
            'actual_salary',
            'jht_perusahaan',
            'jp_perusahaan',
            'jkm',
            'jkk',
            'bpjs_kes_perusahaan',
            'employer_bpjs',
            'thr',
            'bonus',
            'tunj_keseh',
            'lembur',
            'rev_absensi',
            'tunj_pph21',
            'cut_unpaid',
            'cut_absensi',
            'cut_alpha',
            'other_income',
            'bruto',
            'employer_cost',
            'bruto_tax',
            'ter',
            'ter_rate',
            'pph21_dec_net',
            'bruto_tax_year',
            'biaya_jabatan_year',
            'jp_jht_kary_year',
            'ptkp',
            'pkp',
            'neto_year',
            'pph21_year',
            'pph21_jan_nov',
            'pph21_net_employer',
            'pph21',
            'jht_kary',
            'jp_kary',
            'bpjs_kes_kary',
            'ded_misc',
            'total_potongan',
            'thp',
            'status_id',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
