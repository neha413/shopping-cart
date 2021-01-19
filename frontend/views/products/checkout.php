<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\grid\GridView;
// use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Checkout';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="checkout-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="table-responsive">   
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'method' => 'POST', 'action' => Yii::$app->urlManager->createUrl(['products/place-order'])]); ?>       
  <table class="table">
  <thead>
      <tr>
        <th>#</th>
        <th>Product Name</th>
        <th>Quantity</th>
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
    ?>

      <tr>
        <td><?= $i ?></td>
        <td><?= $value['name'] ?></td>
        <td><?= $value['quantity'] ?></td>
        <td><?= $value['price'] ?></td>
        <td><?= $productTotalPrice ?></td>
      </tr>
      
    <?php
    $total = $total + $productTotalPrice;
    $i++;
    }
    ?>
    <tr>
        <td colspan=4 align="right"><strong>Total</strong></td>
        <td><strong><?= $total ?></strong></td>
      </tr>
      <tr>
        <td colspan=4 align="right"><strong>Payment Method</strong></td><td><strong>Cash On Delivery</strong></td>
      </tr>
      <tr>
        <td colspan=5 align="right"><?= Html::submitButton('Place Order', ['class' => 'btn btn-success']) ?></td>
      </tr>
    <?php
}
else { ?>
    <tr>
        <td colspan=5 align="center"><strong>No items are present in your cart</strong></td>
      </tr>
      <?php 
}
    ?>
    </tbody>
    </table>
    <?php ActiveForm::end(); ?>
  </div>
</div>
