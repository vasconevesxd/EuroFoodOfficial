<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meal".
 *
 * @property int $id
 * @property string $name
 *
 * @property ExperienceType[] $experienceTypes
 */
class Meal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExperienceTypes()
    {
        return $this->hasMany(ExperienceType::className(), ['id_meal' => 'id']);
    }
}
