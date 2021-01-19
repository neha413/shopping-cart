<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Order Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-detail-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // Html::a('Create Order Detail', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'order_id',
            // 'product_id',
            ['attribute' => 'product_id',
                    'header' => 'Product Name',
                    'value' => function( $data ) {
                        return $data->product->title;  
// here user is your relation name in base model.
                    },
                ],
                ['attribute' => 'product_id',
                    'header' => 'Product Price',
                    'value' => function( $data ) {
                        return $data->product->price;  
// here user is your relation name in base model.
                    },
                ],
            'quantity',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
