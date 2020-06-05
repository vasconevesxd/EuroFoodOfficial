<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property int $n_like
 * @property int $id_user
 * @property int $id_experiences_type
 * @property int $id
 * @property int $dislike
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['n_like', 'id_user', 'id_experiences_type', 'dislike'], 'required'],
            [['n_like', 'id_user', 'id_experiences_type', 'dislike'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'n_like' => 'N Like',
            'id_user' => 'Id User',
            'id_experiences_type' => 'Id Experiences Type',
            'id' => 'ID',
            'dislike' => 'Dislike',
        ];
    }
}
