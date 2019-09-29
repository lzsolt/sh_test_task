<?php

namespace app\models;

use phpDocumentor\Reflection\Types\This;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $artist
 * @property string $image_url
 * @property float $price
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $added
 * @property string $manufacturer
 * @property string $item_type
 * @property string $created_date
 */
class Item extends \yii\db\ActiveRecord
{
    public $year;
    public $month;
    public $count;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['artist', 'image_url', 'price', 'name', 'description', 'slug', 'added', 'manufacturer', 'item_type'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['added', 'created_date'], 'safe'],
            [['artist', 'image_url', 'name', 'slug', 'manufacturer'], 'string', 'max' => 128],
            [['item_type'], 'string', 'max' => 64],
            [['year', 'month', 'count'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'artist' => 'Artist',
            'image_url' => 'Image Url',
            'price' => 'Price',
            'name' => 'Name',
            'description' => 'Description',
            'slug' => 'Slug',
            'added' => 'Added',
            'manufacturer' => 'Manufacturer',
            'item_type' => 'Item Type',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getItemsStat()
    {
        return self::find()
            ->addSelect(['YEAR(added) AS year', 'MONTH(added) AS month', 'count(*) AS count'])
            ->groupBy(['YEAR(added)', 'MONTH(added)'])
            ->all();
    }
}
