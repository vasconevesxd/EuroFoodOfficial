<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "chef".
 *
 * @property int $id
 * @property string $full_address
 * @property string $about
 * @property string $files
 * @property int $id_users
 * @property int $id_countries
 * @property int $id_language
 *
 * @property Country $countries
 * @property Language $language
 * @property User $users
 * @property ExperienceType[] $experienceTypes
 * @property Order[] $orders
 */
class Chef extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chef';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [ //, 'id_countries', 'id_language'
            [['id_users'], 'required'],
            [['id_users', 'id_countries', 'id_language'], 'integer'],
            [['full_address'], 'string', 'max' => 45],
            [['about'], 'string', 'max' => 500],
            [['files'], 'file', 'extensions' => 'pdf','maxFiles' => 1,'maxSize' => 1000000, 'tooBig' => 'Limit is 1MB'],
            [['id_countries'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id_countries' => 'id']],
            [['id_language'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['id_language' => 'id']],
            [['id_users'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_users' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_address' => 'Full Address',
            'about' => 'About',
            'files' => 'Files',
            'id_users' => 'Id Users',
            'id_countries' => 'Id Countries',
            'id_language' => 'Id Language',
        ];
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
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'id_language']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_users']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExperienceTypes()
    {
        return $this->hasMany(ExperienceType::className(), ['id_chef' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['id_user' => 'id']);
    }
}
