<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $birthday
 * @property string $image
 * @property int $id_validacao
 * @property int $id_users
 *
 * @property User $users
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'id_users'], 'required'],
            [['birthday'], 'safe'],
            [['id_users'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 40],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg','maxFiles' => 1],
            [['id_validacao'], 'integer'],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birthday' => 'Birthday',
            'image' => 'Image',
            'id_validacao' => 'Id Validacao',
            'id_users' => 'Id Users',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasOne(User::className(), ['id' => 'id_users']);
    }
}
