<?php

namespace frontend\models;

use Yii;
use frontend\models\Categories;
use yii\web\UploadedFile;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property string $title
 * @property int $category_id
 * @property string $description
 * @property string $imagename
 * @property string $imagepath
 * @property float $price
 * @property string $status
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Categories $category
 */
class Products extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'imagename', 'imagepath', 'price'], 'required'],
            [['category_id'], 'integer'],
            [['price'], 'number'],
            [['status'], 'string'],
            [['created_at', 'updated_at', 'file'], 'safe'],
            [['title', 'imagename'], 'string', 'max' => 50],
            [['description', 'imagepath'], 'string', 'max' => 250],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['file'], 'file', 'extensions' => 'gif, jpg, png'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'category_id' => 'Category ID',
            'description' => 'Description',
            'imagename' => 'Imagename',
            'imagepath' => 'Imagepath',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
