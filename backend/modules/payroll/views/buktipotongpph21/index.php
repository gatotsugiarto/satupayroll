<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\select2\Select2;


$this->title = "Bukti Potong PPh21";
$subtitle = "Bukti Resmi Pemotongan PPh Pasal 21.";
?>

<?php Pjax::begin(['id' => 'w0-pjax']); ?>

<?php
$gridColumns = [
    // ['class' => 'yii\grid\SerialColumn'],
        // 'id',
        'masa_pajak',
        'tahun_pajak',
        'npwp_perusahaan',
        'nama_perusahaan',
        'npwp_nik_pegawai',
        'nama_pegawai',
        'status_pegawai',
        'kode_objek_pajak',
        'status_ptkp',
        'penghasilan_bruto',
        'biaya_jabatan',
        'iuran_pensiun_jht',
        'penghasilan_neto',
        'pph21_terutang',
        'pph21_dipotong_karyawan',
        'pph21_ditanggung_perusahaan',
        'skema_pajak',
];

$gridColumns_bupot = [
    // ['class' => 'yii\grid\SerialColumn'],
        // 'id',
        // 'employee_id',
        [
            'label' => 'NO_BUKTI_POTONG',
            'value' => function ($model) {
                return $model->employee_id.'-'.$model->tahun_pajak.str_pad($model->masa_pajak, 2, '0', STR_PAD_LEFT).'-'.$model->kode_objek_pajak;
            },
        ],
        [
            'label' => 'MASA_PAJAK',
            'format' => 'raw',
            'value' => function ($model) {
                return str_pad($model->masa_pajak, 2, '0', STR_PAD_LEFT) . '-' . $model->tahun_pajak;
            },
        ],
        [
            'label' => 'NPWP',
            'value' => function ($model) {
                return $model->npwp_nik_pegawai;
            },
        ],
        [
            'label' => 'NAMA',
            'value' => function ($model) {
                return $model->nama_pegawai;
            },
        ],
        [
            'label' => 'KODE_OBJEK',
            'value' => function ($model) {
                return $model->kode_objek_pajak;
            },
        ],
        [
            'label' => 'PENGHASILAN_BRUTO',
            'value' => function ($model) {
                return $model->penghasilan_bruto;
            },
        ],
        [
            'label' => 'POTONGAN',
            'value' => function ($model) {
                return $model->biaya_jabatan + $model->iuran_pensiun_jht;
            },
        ],
        [
            'label' => 'PENGHASILAN_NETO',
            'value' => function ($model) {
                return $model->penghasilan_neto;
            },
        ],
        [
            'label' => 'PPH21_TERUTANG',
            'value' => function ($model) {
                return $model->pph21_terutang;
            },
        ],
        [
            'label' => 'STATUS_PTKP',
            'value' => function ($model) {
                return $model->status_ptkp;
            },
        ],
        [
            'label' => 'TANGGAL',
            'format' => 'raw',
            'value' => function ($model) {
                $date = new \DateTime(sprintf('%04d-%02d-01', $model->tahun_pajak, $model->masa_pajak));
                return $date->format('Y-m-d'); // end of month
            },
        ],
        // 'npwp_perusahaan',
        // 'nama_perusahaan',
        // 'npwp_nik_pegawai',
        // 'nama_pegawai',
        // 'status_pegawai',
        // 'kode_objek_pajak',
        // 'status_ptkp',
        // 'penghasilan_bruto',
        // 'biaya_jabatan',
        // 'iuran_pensiun_jht',
        // 'penghasilan_neto',
        // 'pph21_terutang',
        // 'pph21_dipotong_karyawan',
        // 'pph21_ditanggung_perusahaan',
        // 'skema_pajak',
];

$gridColumns_coretax = [
    // ['class' => 'yii\grid\SerialColumn'],
        // 'id',
        // 'employee_id',
        [
            'label' => 'masa_pajak',
            'value' => function ($model) {
                return $model->masa_pajak;
            },
        ],
        [
            'label' => 'tahun_pajak',
            'value' => function ($model) {
                return $model->tahun_pajak;
            },
        ],
        [
            'label' => 'npwp_pemotong',
            'value' => function ($model) {
                return $model->npwp_perusahaan;
            },
        ],
        [
            'label' => 'nama_pemotong',
            'value' => function ($model) {
                return $model->nama_perusahaan;
            },
        ],
        [
            'label' => 'npwp_nik',
            'value' => function ($model) {
                return $model->npwp_nik_pegawai;
            },
        ],
        [
            'label' => 'nama',
            'value' => function ($model) {
                return $model->nama_pegawai;
            },
        ],
        [
            'label' => 'status_pegawai',
            'value' => function ($model) {
                return $model->status_pegawai;
            },
        ],
        [
            'label' => 'kode_objek_pajak',
            'value' => function ($model) {
                return $model->kode_objek_pajak;
            },
        ],

        [
            'label' => 'status_ptkp',
            'value' => function ($model) {
                return $model->status_ptkp;
            },
        ],
        [
            'label' => 'penghasilan_bruto',
            'value' => function ($model) {
                return $model->penghasilan_bruto;
            },
        ],
        [
            'label' => 'biaya_jabatan',
            'value' => function ($model) {
                return $model->biaya_jabatan;
            },
        ],
        [
            'label' => 'iuran_pensiun_jht',
            'value' => function ($model) {
                return $model->iuran_pensiun_jht;
            },
        ],
        [
            'label' => 'penghasilan_neto',
            'value' => function ($model) {
                return $model->penghasilan_neto;
            },
        ],
        [
            'label' => 'pph21_terutang',
            'value' => function ($model) {
                return $model->pph21_terutang;
            },
        ],
        [
            'label' => 'pph21_dipotong',
            'value' => function ($model) {
                return $model->pph21_dipotong_karyawan;
            },
        ],
        [
            'label' => 'pph21_ditanggung_perusahaan',
            'value' => function ($model) {
                return $model->pph21_ditanggung_perusahaan;
            },
        ],
        [
            'label' => 'skema_pajak',
            'value' => function ($model) {
                return $model->skema_pajak;
            },
        ],
        // 'npwp_perusahaan',
        // 'nama_perusahaan',
        // 'npwp_nik_pegawai',
        // 'nama_pegawai',
        // 'status_pegawai',
        // 'kode_objek_pajak',
        // 'status_ptkp',
        // 'penghasilan_bruto',
        // 'biaya_jabatan',
        // 'iuran_pensiun_jht',
        // 'penghasilan_neto',
        // 'pph21_terutang',
        // 'pph21_dipotong_karyawan',
        // 'pph21_ditanggung_perusahaan',
        // 'skema_pajak',
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
            'filename' => 'Bukti_Potong_PPh_Pasal21_'.date('YmdHis'),
            'showColumnSelector' => false,
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_EXCEL => false,
            ],
            'dropdownOptions' => [
                'label' => '<i class="fa fa-download"></i> Form 1721-I/II',
                'class' => 'btn btn-sm btn-success rounded-pill shadow-sm',
                'style' => 'min-width:160px;',
                'encodeLabel' => false,
            ],
        ]) ?>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            // 'columns' => $gridColumns_bupot,
            'columns' => $gridColumns_coretax,
            'bsVersion' => '4',
            'bootstrap' => true,
            'filename' => 'Coretax_'.date('YmdHis'),
            'showColumnSelector' => false,
            'dropdownOptions' => [
                'label' => '<i class="fa fa-download"></i> Coretax',
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
        // [
        //     'attribute' => 'employee_id',
        //     'format' => 'raw',
        //     'value' => fn($model) => Html::a(
        //         Html::encode($model->employee->fullname)
        //     ),
        // ],
        // 'masa_pajak',
        // 'tahun_pajak',
        // 'npwp_perusahaan',
        // 'nama_perusahaan',
        // 'npwp_nik_pegawai',
        // 'nama_pegawai',
        [
            'attribute' => 'masa_pajak',
            'format' => 'raw',
            'value' => function ($model) {
                return date('F', mktime(0, 0, 0, $model->masa_pajak, 1));
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => [
                1  => 'January',
                2  => 'February',
                3  => 'March',
                4  => 'April',
                5  => 'May',
                6  => 'June',
                7  => 'July',
                8  => 'August',
                9  => 'September',
                10 => 'October',
                11 => 'November',
                12 => 'December',
            ],
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'allowClear' => true,
                    'placeholder' => 'All Type',
                ],
                'options' => ['placeholder' => 'select'],
            ],
            'filterInputOptions' => ['class' => 'form-control'],
            'contentOptions' => ['class' => 'text-left'],
            'headerOptions' => ['class' => 'text-white bg-creative text-left'],
        ],
        'tahun_pajak',
        [
            'attribute' => 'nama_pegawai',
            'format' => 'raw',
            'value' => fn($model) => Html::a(
                Html::encode($model->nama_pegawai),
                'javascript:void(0);',
                [
                    'class' => 'text-primary view-data',
                    'data-url' => Url::to(['view', 'id' => $model->id]),
                ]
            ),
        ],
        'status_pegawai',
        'kode_objek_pajak',
        //'status_ptkp',
        'penghasilan_bruto',
        //'biaya_jabatan',
        //'iuran_pensiun_jht',
        //'penghasilan_neto',
        'pph21_terutang',
        //'pph21_dipotong_karyawan',
        //'pph21_ditanggung_perusahaan',
        //'skema_pajak',

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

