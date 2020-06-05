<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "experience_type".
 *
 * @property int $id
 * @property string $title
 * @property string $images
 * @property string $maps
 * @property int $price
 * @property string $description
 * @property string $start_time
 * @property string $end_time
 * @property int $id_meal
 * @property int $id_countries
 * @property int $status
 * @property int $id_chef
 *
 * @property Comment[] $comments
 * @property Meal $meal
 * @property Country $countries
 * @property Chef $chef
 * @property Order[] $orders
 */
class ExperienceType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'experience_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'images', 'maps', 'price', 'description', 'start_time', 'end_time', 'id_meal', 'id_countries', 'id_chef'], 'required'],
            [['price', 'id_meal', 'id_countries','status', 'id_chef'], 'integer'],
            ['title','match', 'pattern' => '/^[a-zA-Z.,\-\/\s]+$/', 'message' => 'Invalid characters in title.'],
            [['status'],'number','min'=>1,'max'=>2],
            [['price'],'number','min'=>0],
            [['end_time'], 'compare', 'compareAttribute' => 'start_time', 'operator' => '>'],
            [['start_time', 'end_time'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['images'], 'file', 'extensions' => 'png, jpg, jpeg','maxFiles' => 3,'maxSize' => 1000000, 'tooBig' => 'Limit is 1MB'],
            [['description'], 'string', 'max' => 3000],
            [['id_meal'], 'exist', 'skipOnError' => true, 'targetClass' => Meal::className(), 'targetAttribute' => ['id_meal' => 'id']],
            [['id_countries'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id_countries' => 'id']],
            [['id_chef'], 'exist', 'skipOnError' => true, 'targetClass' => Chef::className(), 'targetAttribute' => ['id_chef' => 'id']],
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
            'images' => 'Images',
            'maps' => 'Maps',
            'price' => 'Price',
            'description' => 'Description',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'status' => 'Status',
            'id_meal' => 'Id Meal',
            'id_countries' => 'Id Countries',
            'id_chef' => 'Id Chef',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['id_experiences_type' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeal()
    {
        return $this->hasOne(Meal::className(), ['id' => 'id_meal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasOne(Country::className(), ['id' => 'id_countries']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChef()
    {
        return $this->hasOne(Chef::className(), ['id' => 'id_chef']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id_experiences_type' => 'id']);
    }
}
