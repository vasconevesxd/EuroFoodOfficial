<?php
namespace frontend\controllers;



use common\models\Country;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * Site controller
 */
class LayoutController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }



    public function beforeAction($action)
    {

        $model = new Country();

        $country = Country::find()->all();

        $listcountry = ArrayHelper::map($country,'id','name');

        $this->view->params['listcountry'] = $listcountry;

        if(Yii::$app->user->isGuest){


        }else{
            $user_id = Yii::$app->user->identity->getId();

            $user = User::find()->where(['id' => $user_id])->one();

            $user_profile = UserProfile::find()->where(['id_users' => $user_id])->one();

            $user_role = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

            $this->view->params['user_role'] = $user_role;

            $this->view->params['user'] = $user;

            $this->view->params['user_profile'] = $user_profile;


        }


        $this->view->params['model'] = $model;



        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $data = Yii::$app->request->post();
            $countries_list = $data['Country']['name'];


            if (!empty($countries_list)) {

                return $this->redirect(['experience-type/list-experience','id'=>$countries_list]);

            }else{
                return $this->redirect(['/']);
            }


        }

        return parent::beforeAction($action);
    }


}
