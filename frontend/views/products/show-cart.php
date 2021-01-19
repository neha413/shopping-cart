<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\grid\GridView;
// use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cart';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="cart-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="table-responsive">   
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'method' => 'POST', 'action' => Yii::$app->urlManager->createUrl(['products/checkout'])]); ?>       
  <table class="table">
  <thead>
      <tr>
        <th>#</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Remove</th>
        <th>Price</th>
        <th>Total Price</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    if(count($productCart) > 0) {
        $i = 1;
        $total = 0;
    foreach($productCart as $key => $value) {
        $productTotalPrice = $value['quantity'] * $value['price'];
        
        $orderDetailModel->quantity = $value['quantity'];
        
    ?>

      <tr>
        <td><?= $i ?></td>
        <td><?= $value['name'] ?></td>
        <!-- <td><?= $form->field($orderDetailModel, 'quantity')->dropDownList([ 1 => '1', 2 => '2', 3 => '3', '4' => '4', '5' => '5'], ['onchange' => '$.post(Yii::$app->urlManager->createUrl . "products/update-cart"), function(data) {alert(data)}'])->label(false) ?></td> -->
        <td><?= $value['quantity']?></td>
        <td><?= Html::a('Remove', ['/products/remove-product','id' => $key])?></td>
        <td><?= $value['price'] ?></td>
        <td><?= $productTotalPrice ?></td>
      </tr>
      
    <?php
    $total = $total + $productTotalPrice;
    $i++;
    }
    ?>
    <tr>
        <td colspan=5 align="right"><strong>Total</strong></td>
        <td><strong><?= $total ?></strong></td>
      </tr>
      <tr>
        <td colspan=6 align="right"><?= Html::submitButton('Check-Out', ['class' => 'btn btn-success']) ?></td>
      </tr>
    <?php
}
else { ?>
    <tr>
        <td colspan=6 align="center"><strong>No items are present in your cart</strong></td>
      </tr>
      <?php 
}
    ?>
    </tbody>
    </table>
    <?php ActiveForm::end(); ?>
  </div>
</div>
