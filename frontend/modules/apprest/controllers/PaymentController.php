<?php

namespace frontend\modules\apprest\controllers;
use common\models\Payment;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * PaymentController implements the CRUD actions for Chef model.
 */
class PaymentController extends ActiveController {

       public $modelClass = 'common\models\Payment';

       public function behaviors()
       {
               $behaviors = parent::behaviors();
               $behaviors['authenticator'] = [
                   'class' => QueryParamAuth::className(),
               ];
               return $behaviors;
       }


    public function actionAllpayment() {

        $allpayment = Payment::find()->all();

        return $allpayment;

    }

    public function actionAddpayment() { //Inserir um novo payment

        $paymentmodel = new Payment();
        $paymentmodel->price = Yii::$app->request->post('price');
        $paymentmodel->id_orders = Yii::$app->request->post('id_orders');
        $paymentmodel->card_number = Yii::$app->request->post('card_number');
        $paymentmodel->expiration_year = Yii::$app->request->post('expiration_year');
        $paymentmodel->expiration_month = Yii::$app->request->post('expiration_month');
        $paymentmodel->cvcode = Yii::$app->request->post('cvcode');

        if(!$paymentmodel->validate()){
            \Yii::$app->response->statusCode=409;
            return $paymentmodel->getErrors();
        }

        $paymentmodel->save();

        $last_payment = Payment::find()->orderBy(['id'=>SORT_DESC])->one();

        return ["payment"=>$last_payment];

    }


}
?>
