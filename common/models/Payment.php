<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $price
 * @property int $id_orders
 * @property int $card_number
 * @property int $expiration_month
 * @property int $expiration_year
 * @property string $cvcode
 *
 * @property Order $orders
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'id_orders'], 'integer'],
            [['id_orders', 'card_number', 'expiration_month', 'expiration_year', 'cvcode'], 'required'],
            [['cvcode'],'string','min'=>000],
            [['expiration_month'],'number','min'=>1,'max'=>12],
            [['card_number'],'number'],
            [['expiration_year'], 'number', 'min'=>2019, 'max'=>2999],
            [['expiration_year'], 'safe'],
            [['id_orders'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['id_orders' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'id_orders' => 'Id Orders',
            'card_number' => 'Card Number',
            'expiration_month' => 'Expiration Month',
            'expiration_year' => 'Expiration Year',
            'cvcode' => 'Cvcode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Order::className(), ['id' => 'id_orders']);
    }
}
