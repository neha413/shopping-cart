<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Products;
use frontend\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\Orders;
use backend\models\OrderDetail;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
{
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('view','index'),
				'users'=>array('?'),
			),

            array('deny',  // deny all users
                'actions'=>array('create','update','delete'),
				'users'=>array('*'),
			),
		);
    }
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $ordersModel = new Orders();
        $orderDetailModel = new OrderDetail();
        $productList = Products::find()->where('status="1"')->asArray()->all();
        return $this->render('index', [
                'productList' => $productList,
                'ordersModel' => $ordersModel,
                'orderDetailModel' => $orderDetailModel,
            ]);
    }

    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate1()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file) {                

                $model->imagename = $model->file->baseName . uniqid() .'.' . $model->file->extension;
                $model->imagepath = Yii::$app->basePath .'/web/uploads/' . $model->imagename;

                if($model->save()){
                    $model->file->saveAs($model->imagepath);
                
                    return $this->redirect(['index']);
                    //return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate1($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['index']);
                //return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete1($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    function actionAddToCart()
	{
        $session = Yii::$app->session;
		if(Yii::$app->request->post()) {
            
            $post = Yii::$app->request->post();
			if(isset($post["product_id"]) && isset($post['OrderDetail']["quantity"])) {
                $product = Products::findOne($post["product_id"]);
                
                $getArr = $session->get('productCart');
                if(!empty($getArr)) {
                    
                    if(array_key_exists('product_'.$post["product_id"], $getArr)) { 
                        $qty = $getArr['product_'.$post["product_id"]]['quantity'] + $post['OrderDetail']["quantity"];
                        $getArr['product_'.$post["product_id"]]['quantity'] = $qty;
                    }
                    else {
                        $getArr['product_'.$post["product_id"]] = array('name' => $product['title'], 'price' => $product['price'], 'quantity' => $post['OrderDetail']["quantity"]);
                    }
                   
                    $session->set('productCart', $getArr);
                }
                else {
                    $arr = [];
                    $arr['product_'.$post["product_id"]] = array('name' => $product['title'], 'price' => $product['price'], 'quantity' => $post['OrderDetail']["quantity"]);
                    $session->set('productCart', $arr);
                }  
                Yii::$app->session->setFlash('success', "Item successfully added to your cart.");
                return $this->redirect(['index']);
			}
		}
    }
    
    function actionShowCart() {
        $session = Yii::$app->session;
        $orderDetailModel = new OrderDetail();
        $arr = [];
        if(!empty($session->get('productCart'))) {
            $arr = $session->get('productCart');
        }
        return $this->render('show-cart', ['productCart' => $arr, 'orderDetailModel' => $orderDetailModel]);
    }

    function actionCheckout() {
        $session = Yii::$app->session;
        $arr = [];
        if(!empty($session->get('productCart'))) {
            $arr = $session->get('productCart');
        }
        if(!Yii::$app->user->isGuest) {
            return $this->render('checkout', ['productCart' => $arr]);
        }
        else {
            Yii::$app->session->setFlash('error', "Please login to checkout");
            return $this->redirect(['site/login']);
            //return $this->render('show-cart', ['productCart' => $arr]);
        }
        
    }

    function actionPlaceOrder() {
        $session = Yii::$app->session;
        $arr = [];
        if(!empty($session->get('productCart'))) {
            $arr = $session->get('productCart');
            $model = new Orders();
            

            $model->user_id = Yii::$app->user->id;
            $total = 0;
            foreach($arr as $key => $val) {
                $total = $total + ($val['quantity'] * $val['price']);
            }
            $model->total_price = $total;
            $model->order_date = date('Y-m-d H:i:s');
            $model->save();
            if($model->order_id) {
                foreach($arr as $key => $val) {
                    $model1 = new OrderDetail();
                    $model1->order_id = $model->order_id;
                    $pid = explode('_',$key);
                    $model1->product_id = $pid[1];
                    $model1->quantity = $val['quantity'];
                    $model1->save();
                }
            }
            Yii::$app->session->setFlash('success', "Order placed successfully");
            $session->remove('productCart');
            return $this->redirect(['index']);
        }
    }

    function actionRemoveProduct($id) {
        $session = Yii::$app->session;
        if(!empty($session->get('productCart'))) {
            $arr = $session->get('productCart');
            if(array_key_exists($id, $arr)) {
                unset($arr[$id]);
                $session->set('productCart', $arr);
                Yii::$app->session->setFlash('success', "Item successfully removed from your cart");
                return $this->redirect(['show-cart']);
            }
        }
    }
}
