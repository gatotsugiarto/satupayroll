<?php

use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

$this->title = "User Assignments";
?>

<?php Pjax::begin(['id' => 'w0-pjax']); ?>

<?php
$gridColumns = [
    ['class' => 'yii\grid\SerialColumn'],
    'item_name',
    'user.fullname',
    // 'fullname',
    // 'auth_key',
    // 'email',
    // [
    //     'attribute' => 'status',
    //     'format' => 'raw',
    //     'value' => function ($model) {
    //         if($model){
    //             if($model->status == 10){
    //                 return $model->status ? 'Active' : 'Suspend';
    //             }
    //         }else{
    //             return '-';
    //         }
    //     },
    // ],
];
?>

<!-- ALERT CONTAINER -->
<!-- <div id="alert-container"></div> -->

<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <div class="text-primary fw-bold page-title"><i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;<?= Html::encode($this->title) ?></div>
        <small class="text-muted">The following is the user with assignment in the system.</small>
    </div>
    <div>
        <?= ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'bsVersion' => '4',
            'bootstrap' => true,
            'filename' => 'User_Assignment_Export_' . date('YmdHis'),
            'showColumnSelector' => false,
            'exportConfig' => [
                ExportMenu::FORMAT_HTML => false,
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_EXCEL => false,
            ],
            'dropdownOptions' => [
                'label' => '<i class="fa fa-download"></i> Export',
                'class' => 'btn btn-sm btn-success rounded-pill shadow-sm',
                'style' => 'min-width:160px;',
                'encodeLabel' => false,
            ],
        ]) ?>
    </div>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'panel' => false,
    'bordered' => false,
    'striped' => false,
    'condensed' => false,
    'hover' => true,
    'resizableColumns' => false,
    'export' => false,
    'responsiveWrap' => false,
    'tableOptions' => ['class' => 'table table-hover table-striped align-middle shadow-sm'],
    'layout' => "{items}\n<div class='d-flex justify-content-between align-items-center mt-2'>{pager}{summary}</div>",
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn', 
            'header' => 'No',
        ],
        [
            'attribute' => 'item_name', 
        ],
        [
            'attribute' => 'user_id',
            'format' => 'raw',
            'value' => function ($model) {
                if($model){
                    return $model->user->fullname;
                }else{
                    return '-';
                }
            },
        ],
    ],
]) ?>

<?php Pjax::end(); ?>
