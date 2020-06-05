<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "language".
 *
 * @property int $id
 * @property string $name
 *
 * @property Chef[] $chefs
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'language';
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
    public function getChefs()
    {
        return $this->hasMany(Chef::className(), ['id_language' => 'id']);
    }
}
