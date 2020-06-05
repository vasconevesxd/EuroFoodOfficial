<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 *
 * @property Chef[] $chefs
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 45],
            ['name', 'match', 'pattern' => '/^[a-zA-Z0-9.,\-\/\s]+$/', 'message' => 'Invalid characters in country.'],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg','maxSize' => 1000000, 'tooBig' => 'Limit is 1MB'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChefs()
    {
        return $this->hasMany(Chef::className(), ['id_countries' => 'id']);
    }
}
