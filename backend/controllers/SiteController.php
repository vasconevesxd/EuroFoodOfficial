<?php
namespace backend\controllers;

use common\models\Chef;
use common\models\Comment;
use common\models\Country;
use common\models\ExperienceType;
use common\models\Payment;
use common\models\User;
use common\models\UserProfile;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['admin'],
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

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $experiences = ExperienceType::find()->count();
        $users = UserProfile::find()->count();
        $chef = Chef::find()->count();
        $countries = Country::find()->count();
        $comments = Comment::find()->count();
        $payments = Payment::find()->count();

        return $this->render('index', [
            'experiences' => $experiences,
            'users' => $users,
            'chef' => $chef,
            'countries' => $countries,
            'comments' => $comments,
            'payments' => $payments,

        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        $model = new LoginForm();

        $the_user = ArrayHelper::getValue(Yii::$app->request->post(), 'LoginForm.username');
        $user = User::find()->where(['username'=>$the_user])->one();
        $role_user = Yii::$app->authManager->getRolesByUser($user['id']);
        $the_role = ArrayHelper::getValue($role_user, 'chef.name');


        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if ($the_role != 'chef' && $the_role != 'costumer'){

                return $this->goBack();

            }else{


                $model->password = '';

                return $this->redirect('login');
            }


        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
