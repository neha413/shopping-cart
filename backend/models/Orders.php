<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $order_id
 * @property int $user_id
 * @property float $total_price
 * @property string $order_date
 * @property string|null $modified_date
 * @property string $order_status 1=Active,0=Cancelled, 2= Completed
 *
 * @property User $user
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'total_price'], 'required'],
            [['user_id'], 'integer'],
            [['total_price'], 'number'],
            [['order_date', 'modified_date'], 'safe'],
            [['order_status'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'total_price' => 'Total Price',
            'order_date' => 'Order Date',
            'modified_date' => 'Modified Date',
            'order_status' => 'Order Status',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
