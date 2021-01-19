<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //Html::a('Create Orders', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'order_id',
            // 'user_id',
            ['attribute' => 'user_id',
                    'header' => 'User Name',
                    'value' => function( $data ) {
                        return $data->user->username;  
// here user is your relation name in base model.
                    },
                ],
            'total_price',
            'order_date',
            // 'modified_date',
            //'order_status',
                [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}' ,
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('View', ['order-detail/index', 'id'=>$model->order_id]);
                    },
                ]
            ]
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
