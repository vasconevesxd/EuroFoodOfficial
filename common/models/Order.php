<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_experiences_type
 * @property string $data_order
 *
 * @property User $user
 * @property ExperienceType $experiencesType
 * @property Payment[] $payments
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_experiences_type','experience_time', 'data_order'], 'required'],
            [['id_user', 'id_experiences_type','guest_number'], 'integer'],
            [['experience_time'], 'safe'],
            [['data_order'], 'safe'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_experiences_type'], 'exist', 'skipOnError' => true, 'targetClass' => ExperienceType::className(), 'targetAttribute' => ['id_experiences_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'guest_number' => 'Guest Number',
            'experience_time' => 'Experience Time',
            'id_experiences_type' => 'Id Experiences Type',
            'data_order' => 'Data Order',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
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
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['id_orders' => 'id']);
    }
}
