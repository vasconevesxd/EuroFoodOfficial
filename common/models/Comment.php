<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property int $id
 * @property string $comments
 * @property int $id_experiences_type
 * @property int $id_users
 * @property string $create_at
 *
 * @property ExperienceType $experiencesType
 * @property User $users
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_experiences_type', 'id_users'], 'integer'],
            [['id_experiences_type', 'id_users', 'create_at'], 'required'],
            [['create_at'], 'safe'],
            [['comments'], 'string', 'max' => 255],
            [['id_experiences_type'], 'exist', 'skipOnError' => true, 'targetClass' => ExperienceType::className(), 'targetAttribute' => ['id_experiences_type' => 'id']],
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
            'comments' => 'Comments',
            'id_experiences_type' => 'Id Experiences Type',
            'id_users' => 'Id Users',
            'create_at' => 'Create At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExperiencesType()
    {
        return $this->hasOne(ExperienceType::className(), ['id' => 'id_experiences_type']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_users']);
    }
}
