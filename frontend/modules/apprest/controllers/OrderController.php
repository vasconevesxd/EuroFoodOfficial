<?php

namespace frontend\modules\apprest\controllers;
use common\models\Order;
use common\models\Payment;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;


/**
 * OrderController implements the CRUD actions for Chef model.
 */
class OrderController extends ActiveController {

    public $modelClass = 'common\models\Order';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        return $behaviors;
    }

    public function actionAllorder() {

        $allorder = Order::find()->all();

        return $allorder;

    }


    public function actionAddorder() { //Inserir uma nova Order

        $ordermodel = new Order();
        $ordermodel->data_order = Yii::$app->request->post('data_order');
        $ordermodel->guest_number = Yii::$app->request->post('guest_number');
        $ordermodel->experience_time = Yii::$app->request->post('experience_time');
        $ordermodel->id_experiences_type = Yii::$app->request->post('id_experiences_type');
        $ordermodel->id_user = Yii::$app->request->post('id_user');

        if(!$ordermodel->validate()){
            \Yii::$app->response->statusCode=400;
            return $ordermodel->getErrors();
        }

        $ordermodel->save();

        $last_order = Order::find()->orderBy(['data_order'=>SORT_DESC])->one();

        return ["order"=>$last_order];

    }


    public function actionDelorder() //Apagar um order
    {
        if(Order::find()->where(['id'=>Yii::$app->request->post('id')])->one() === null){ //Verificar se a order existe


            return "Order doesn't exist.";


        }else{
            if (Payment::find()->where(['id_orders'=>Yii::$app->request->post('id')])->one() != null) { //Verificar se a Order tem Payment relacionado

                return "Payment exist...";

            }else{

                $climodel = new $this->modelClass;
                $order_id = Yii::$app->request->post('id');

                $ret=$climodel->deleteAll("id=".$order_id );
                if($ret) {
                    \Yii::$app->response->statusCode = 200;
                    return ['code'=>'ok'];
                }
            }
        }
    }
}
?>
