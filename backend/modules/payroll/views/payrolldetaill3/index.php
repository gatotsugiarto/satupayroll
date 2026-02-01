<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\select2\Select2;


$this->title = "L3 Payroll Summaries";
$subtitle = "Summary of payroll results and financial breakdown.";
?>

<?php Pjax::begin(['id' => 'w0-pjax']); ?>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'employee_id',
            'format' => 'raw',
            'value' => fn($model) => Html::a(
                Html::encode($model->employee->fullname)
            ),
        ],
        'period_code',
        'payroll_mode',
        // 'generate_mode',
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
];
?>

<!-- ALERT CONTAINER -->
<div id="alert-container"></div>

<!-- PAGE HEADER -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <div class="text-primary fw-bold page-title"><i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></div>
        <small class="text-muted"><?=$subtitle ?></small>
    </div>
    <div>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'bsVersion' => '4',
            'bootstrap' => true,
            'filename' => 'L3_Payroll_Summary_Export_'.date('YmdHis'),
            'showColumnSelector' => false,
            'dropdownOptions' => [
                'label' => '<i class="fa fa-download"></i> Export',
                'class' => 'btn btn-sm btn-success rounded-pill shadow-sm',
                'style' => 'min-width:160px;',
                'encodeLabel' => false,
            ],
        ]) ?>

        
    </div>
</div>

<!-- GRIDVIEW -->
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'  => $searchModel,
    'hover' => true,
    'resizableColumns' => false,
    'export' => false,
    'tableOptions' => [
        'class' => 'table table-hover table-striped align-middle shadow-sm'
    ],
    'layout' => "{items}\n<div class='d-flex justify-content-between align-items-center mt-2'>{pager}{summary}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn', 'header' => 'No'],
        // 'id',
        [
            'attribute' => 'employee_id',
            'format' => 'raw',
            'value' => fn($model) => Html::a(
                Html::encode($model->employee->fullname)
            ),
        ],
        'period_code',
        'payroll_mode',
        // 'generate_mode',
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
        //'status_id',
        //'created_at',
        //'created_by',
        //'updated_at',
        //'updated_by',
        // [
        //     'attribute' => 'gross',
        //     'width' => '150px',
        //     'hAlign' => 'right',
        //     'format' => ['decimal', 2],
        //     'pageSummary' => true,
        // ],
        // [
        //     'attribute' => 'total_deduction',
        //     'width' => '150px',
        //     'hAlign' => 'right',
        //     'format' => ['decimal', 2],
        //     'pageSummary' => true,
        // ],
        // [
        //     'attribute' => 'thp',
        //     'width' => '150px',
        //     'hAlign' => 'right',
        //     'format' => ['decimal', 2],
        //     'pageSummary' => true,
        // ],
        // [
        //     'attribute' => 'payroll_item_id',
        //     'value' => 'payrollItem.name',
        //     'filter' => yii\helpers\ArrayHelper::map(\common\modules\master\models\PayrollItem::find()->where(['type' => 'DATA'])->orderBy('id')->asArray()->all(),'id','name'),
        //     'filterType' => GridView::FILTER_SELECT2,
        //     'filterWidgetOptions' => [
        //         'pluginOptions' => [
        //             'allowClear' => true,
        //             'placeholder' => 'Payroll Component',
        //         ],
        //         'options' => ['placeholder' => 'Payroll Component'],
        //     ],
        //     'filterInputOptions' => ['class' => 'form-control'],
        //     'contentOptions' => ['class' => 'text-left'],
        //     'headerOptions' => ['class' => 'text-white bg-creative text-center'],
        // ],
        // [
        //     'attribute' => 'amount',
        //     'width' => '150px',
        //     'hAlign' => 'right',
        //     'format' => ['decimal', 2],
        //     'pageSummary' => true,
        // ],
        // [
        //     'attribute' => 'salary_type',
        //     'format' => 'raw',
        //     'value' => function ($model) {
        //         return $model->payrollItem->salary_type;
        //     },
        //     'filterType' => GridView::FILTER_SELECT2,
        //     'filter' => ['RECURRING' => 'RECURRING', 'ONETIME' => 'ONETIME'],
        //     'filterWidgetOptions' => [
        //         'pluginOptions' => [
        //             'allowClear' => true,
        //             'placeholder' => 'All Type',
        //         ],
        //         'options' => ['placeholder' => 'All Type'],
        //     ],
        //     'filterInputOptions' => ['class' => 'form-control'],
        //     'contentOptions' => ['class' => 'text-center'],
        //     'headerOptions' => ['class' => 'text-white bg-creative text-center'],
        // ],
        // 'insert_by',
        // [
        //     'attribute' => 'status_id',
        //     'format' => 'raw',
        //     'value' => function ($model) {
        //         if ($model->status_id == 1) {
        //             return Html::a(
        //                 Html::tag('span', 'Draft', ['class' => 'badge badge-warning'])
        //             );
        //         } else if ($model->status_id == 2) {
        //             return Html::a(
        //                 Html::tag('span', 'Approved', ['class' => 'badge badge-success'])
        //             );
        //         } else {
        //             return Html::a(
        //                 Html::tag('span', 'Pending', ['class' => 'badge badge-danger'])
        //             );
        //         }
        //     },
        //     'filterType' => GridView::FILTER_SELECT2,
        //     'filter' => [1 => 'Draft', 2 => 'Approved', 3 => 'Pending'],
        //     'filterWidgetOptions' => [
        //         'pluginOptions' => [
        //             'allowClear' => true,
        //             'placeholder' => 'All Status',
        //         ],
        //         'options' => ['placeholder' => 'All Status'],
        //     ],
        //     'filterInputOptions' => ['class' => 'form-control'],
        //     'contentOptions' => ['class' => 'text-center'],
        //     'headerOptions' => ['class' => 'text-white bg-creative text-center'],
        // ],
        //'is_processed',
        //'processed_at',
        //'created_at',
        //'created_by',
        //'updated_at',
        //'updated_by',
        // [
        //     'class' => 'yii\grid\ActionColumn',
        //     'header' => 'Action',
        //     'template' => '{slip}',
        //     'contentOptions' => ['class' => 'text-center'],
        //     'buttons' => [
        //         'slip' => function ($url, $model) {
        //             return Html::a(
        //                 '<i class="fa fa-print"></i>',
        //                 Url::to(['slip', 'id' => $model->id]),
        //                 [
        //                     'class' => 'btn btn-sm btn-outline-warning rounded-circle',
        //                     'title' => 'Print Slip',
        //                     'target' => '_blank', // 🔥 open new tab
        //                     'data-pjax' => 0,     // 🔥 penting biar PJAX gak intercept
        //                 ]
        //             );
        //         },
        //     ],
        // ],
    ],
]) ?>

<?php Pjax::end(); ?>


<!-- =======================================================
ADD/EDIT MODAL
========================================================= -->
<div class="modal fade" id="appModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-body p-4"></div>
        </div>
    </div>
</div>

<!-- ========================================================
DELETE MODAL
========================================================= -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                Are you sure want to delete <strong id="delete-modal-name"></strong>?
            </div>
            <div class="modal-footer">
                <?= Html::button('<i class="fa fa-times"></i> Cancel', [
                    'class' => 'btn btn-outline-secondary mr-2 px-4',
                    'data-dismiss' => 'modal',
                    'style' => 'min-width:140px;',
                ]) ?>
                <form id="delete-modal-form" method="post">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                    <?= Html::submitButton('<i class="fa fa-trash"></i> Delete', [
                        'class' => 'btn btn-danger px-4',
                        'style' => 'min-width:140px;',
                        'id' => 'delete-btn'
                    ]) ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VIEW MODAL -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-body p-4"></div>
        </div>
    </div>
</div>

<!-- ========================================================
CONFIRM MODAL
========================================================= -->
<div class="modal fade" id="confirmActiveNonActiveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle"></i> <span class="data-title"></span> Confirmation</h5>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to <span class="data-title"></span> <strong id="data-name"></strong>?</p>
            </div>
            <div class="modal-footer">
                <?= Html::button('<i class="fa fa-times"></i> Cancel', [
                    'class' => 'btn btn-outline-secondary mr-2 px-4',
                    'data-dismiss' => 'modal',
                    'style' => 'min-width:140px;',
                ]) ?>
                <form id="data-url" method="post">
                    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>
                    <?= Html::submitButton('<i class="fa fa-trash"></i> <span class="data-title"></span>', [
                        'class' => 'btn btn-warning px-4',
                        'style' => 'min-width:140px;',
                    ]) ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
/* =========================================================
 * VIEW JS
 * ======================================================= */
$(document).on('click', '.view-data', function() {
    $('#viewModal').modal('show').find('.modal-body').load($(this).data('url'));
});


/* =========================================================
 * ADD/EDIT JS
 * ======================================================= */
$(document).on('click', '.create-data, .edit-data', function () {
    $('#appModal .modal-body').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x text-muted"></i></div>');
    $('#appModal').modal('show').find('.modal-body').load($(this).data('url'));
});

$(document).on('beforeSubmit', '#employee_pending-form', function (e) {
    e.preventDefault();

    const form = $(this);

    $.post(form.attr('action'), form.serialize(), function (res) {

        if (res && res.success) {
            $('#appModal').modal('hide');

            $.pjax.reload({
                container: '#w0-pjax',
                timeout: 500
            }).done(function () {

                $('#alert-container').html(
                    '<div class="alert alert-success alert-dismissible fade show mt-3">' +
                    '<i class="fa fa-check-circle"></i> ' +
                    (res.message || 'Operation successful.') +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '</div>'
                );
            });

        } else if (res && res.errors) {
            form.yiiActiveForm('updateMessages', res.errors, true);
        }

    }, 'json');

    return false;
});



/* =========================================================
 * DELETE JS
 * ======================================================= */
$(document).on('click', '.delete-js', function () {
    $('#delete-modal-name').text($(this).data('name'));
    $('#delete-modal-form').attr('action', $(this).data('url'));
    $('#confirmDeleteModal').modal('show');
});

$(document).on('submit', '#delete-modal-form', function(e) {
    e.preventDefault();
    var form = $(this);
    $.post(form.attr('action'), { _csrf: yii.getCsrfToken() }, function(res) {
        $('#confirmDeleteModal').modal('hide');
        $.pjax.reload({container: '#w0-pjax', timeout: 500}).done(function() {
            if (res && res.success) {
                var html = '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">' +
                           '<i class="fa fa-check-circle"></i> ' + (res.message || 'Operation successful.') +
                           '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                           '<span aria-hidden="true">&times;</span></button>' +
                           '</div>';
                $('#alert-container').html(html);
            }
        });
    }, 'json').fail(function() {
        alert('Request failed. Check console for details.');
    });
});

/* =========================================================
 * ACTIVE-NONACTIVE JS
 * ======================================================= */
$(document).on('click', '.nonactive-js, .reactive-js', function (e) {
    e.preventDefault();

    var url = $(this).data('url');
    var name = $(this).data('name');
    var title = $(this).data('title');

    $('.data-title').text(title);
    $('#data-name').text(name);
    $('#data-url').attr('action', url);
    $('#confirmActiveNonActiveModal').modal('show');
});


JS);
?>

