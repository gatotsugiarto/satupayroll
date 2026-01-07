<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\auth\models\UserAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!--p>
        <?= Html::a('Create User Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
            [
                'attribute' => 'user_id',
                'value' => 'username.username',
                'filter' => yii\helpers\ArrayHelper::map(\common\modules\auth\models\User::find()->orderBy('id')->asArray()->all(),'id','username'),
            ],
            //'created_at',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
