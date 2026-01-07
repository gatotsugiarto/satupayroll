<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\select2\Select2;

$this->title = "Employee Join & Resignation";
?>

<?php Pjax::begin(['id' => 'w0-pjax']); ?>

<?php
$gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=> 'Keterangan',
                'attribute'=>'identity_id',
                'value' => function ($data) {
                    if($data->identity_id == 1){
                        return 'Karyawan Baru';
                    }else{
                        return 'Karyawan Resign';
                    }
                },
            ],
            [
                'label'=>'Nama Pegawai',
                'attribute'=>'fullname',
            ],
            [
                'label'=>'NIP',
                'attribute'=>'e_number',
            ],
            [
                'label'=>'Jabatan',
                'attribute'=>'jabatan',
            ],
            [
                'label'=>'Divisi',
                'attribute'=>'division',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => ['style' => 'width:60px;'],
                'template' => '{register}',
                'buttons' => [
                    'register' => function ($url, $model, $key) {
                        return Html::a(
                            Html::tag('span', '<i class="fa fa-plus-circle"></i>', ['class' => 'badge badge-success']),
                            'javascript:void(0);',
                            [
                                'class' => 'text-primary register-js',
                                'data-url' => Url::to(['../../master/employee/register', 'id' => $model->id]),
                                'title' => 'Register',
                                'data-title' => 'Register Employee',
                                'data-name' => $model->fullname,
                            ]
                        );
                    },
                    'resign' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a('<i class="fa fa-minus-circle"></i>', $url, ['title' => 'Aktif/ Non Aktifkan']);
                    },
                ],
                'visibleButtons' => [
                    'register'=> function($model){
                        if(($model->identity_id == 1) && ($model->status_id == 1)){
                            return true;
                        }else{
                            return false;
                        }
                    },
                    'resign'=> function($model){
                        return $model->list_resign();
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'register') {
                        $url = '../../master/employee/register?id='.$model->id;
                        return $url;
                    }

                    if ($action === 'resign') {
                        $data = $model->list_resign();
                        // $url = '../../master/employee/index';
                        if($data == 0){
                            $url = '../../master/employee/activeemployee?id='.$model->id;
                        }else{
                            $url = '../../master/employee/resignemployee?id='.$model->id;
                        }
                        return $url;
                    }
                }
            ],
        ];
?>

<!-- ALERT CONTAINER -->
<div id="alert-container"></div>

<!-- PAGE HEADER -->
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <div class="text-primary fw-bold page-title"><i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></div>
        <small class="text-muted">Overview of joined and resigned employees for the period</small>
    </div>
    <div>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'bsVersion' => '4',
            'bootstrap' => true,
            'filename' => 'Company_Export_'.date('YmdHis'),
            'showColumnSelector' => false,
            'dropdownOptions' => [
                'label' => '<i class="fa fa-download"></i> Export',
                'class' => 'btn btn-sm btn-success rounded-pill shadow-sm',
                'style' => 'min-width:160px;',
                'encodeLabel' => false,
            ],
        ]) ?>

        <?php
        //  Html::button('<i class="fa fa-plus"></i> New Company', [
        //     'class' => 'btn btn-primary btn-sm rounded-pill shadow-sm create-company',
        //     'style' => 'min-width:160px;',
        //     'data-url' => Url::to(['create']),
        // ]) 
        ?>
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
    'columns' => $gridColumns,
]) ?>

<?php Pjax::end(); ?>


<!-- APP MODAL -->
<!-- ========================================================
CONFIRM MODAL
========================================================= -->
<div class="modal fade" id="confirmRegisterModal" tabindex="-1" aria-hidden="true">
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

$(document).on('beforeSubmit', '#salary-form', function (e) {
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
$(document).on('click', '.register-js, .reactive-js', function (e) {
    e.preventDefault();

    var url = $(this).data('url');
    var name = $(this).data('name');
    var title = $(this).data('title');

    $('.data-title').text(title);
    $('#data-name').text(name);
    $('#data-url').attr('action', url);
    $('#confirmRegisterModal').modal('show');
});


JS);
?>
