<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\grid\GridView;
// use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    foreach($productList as $key => $value) {
    ?>
    <div class="col-sm-4">
      <div class="panel panel-primary">
        <div class="panel-heading"><?= $value['title'] ?></div>
        <div class="panel-body"><img src="<?= $value['imagepath']?>" class="img-responsive" style="width:100%" alt="Image"></div>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'method' => 'POST', 'action' => Yii::$app->urlManager->createUrl(['products/add-to-cart'])]); ?>
        <?= Html::hiddenInput('product_id', $value['id']); ?>
        <div class="panel-footer">
        <?= $form->field($orderDetailModel, 'quantity')->dropDownList([ 1 => '1', 2 => '2', 3 => '3', '4' => '4', '5' => '5']) ?>
            <div class="form-group">
        <?= Html::submitButton('Add to cart', ['class' => 'btn btn-success']) ?>
    </div>
        </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
    <?php
    }
    ?>

    <p>
        <?php //Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'category_id',
            'description',
            'imagename',
            //'imagepath',
            //'price',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); */
    ?>

    <?php //Pjax::end(); ?>

</div>
