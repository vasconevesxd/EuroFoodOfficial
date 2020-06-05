<?php

namespace frontend\controllers;

use common\models\Chef;
use common\models\Country;
use common\models\ExperienceType;
use common\models\Language;
use common\models\User;
use Yii;
use common\models\UserProfile;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\rbac\DbManager;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * UserProfileController implements the CRUD actions for UserProfile model.
 */
class UserProfileController extends LayoutController
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
                        'allow' => true,
                        'actions' => ['index','view','update'],
                        'roles' => ['admin','chef','costumer'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Displays a single UserProfile model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    /**
     * Updates an existing UserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $request = Yii::$app->request;


        $model_chef = new Chef();

        $current_chef = Chef::find()->where(['id_users'=>Yii::$app->user->id])->one();

        $country = Country::find()->all();
        $listData = ArrayHelper::map($country,'id','name');

        $lang = Language::find()->all();
        $listDataLang = ArrayHelper::map($lang,'id','name');

        $user_role = \Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $model->image = UploadedFile::getInstance($model, "image");

            $user_id = Yii::$app->user->identity->getId();

            $path = 'upload/user_profile/'.$user_id.'/';

            $user_log = Yii::$app->user->getId();

            $user_profile = UserProfile::find()->where(['id_users' => $user_log])->one();

            $user_image = $user_profile->image;

            FileHelper::createDirectory($path);


            if(file_exists($path.$user_image)){


                if(!FileHelper::unlink($path.$user_image)){

                    if($model->image == null){

                    }else{

                    $MainImageNew = uniqid() . '_image_' . $model->first_name . '.' . $model->image->extension;

                    $model->image->saveAs($path . $MainImageNew);

                    $model->image = $path . $MainImageNew;

                    $model->save();

                    }

                }


            }else{

                FileHelper::createDirectory($path);
                if($model->image == null){

                }else {
                    $MainImageNew = uniqid() . '_image_' . $model->first_name . '.' . $model->image->extension;

                    $model->image->saveAs($path . $MainImageNew);

                    $model->image = $path . $MainImageNew;

                    $model->save();
                }

            }


            if(isset($_POST['submit']) && $_POST['submit']=='chef')
            {
                $user = Yii::$app->user->id;
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('chef');
                $roles = $auth->getRole('costumer');
                $auth->revoke($roles,$user);
                $roless = $auth->getRole('admin');
                $auth->revoke($roless,$user);
                $auth->assign($role, $user);

                $model_chef->id_users = Yii::$app->user->id;
                $model_chef->save(false);

            }
            else if(isset($_POST['submit']) && $_POST['submit']=='costummer')
            {

                $the_user = Yii::$app->authManager->getRolesByUser($user_profile['id_users']);

                if(ArrayHelper::getValue($the_user, 'chef.name') == 'chef'){

                    if(Chef::find()->where(['id_users'=>$user_profile['id_users']])->one() != null){

                        $the_chef = Chef::find()->where(['id_users'=>$user_profile['id_users']])->one();
                        $exp = ExperienceType::find()->where(['id_chef'=>$the_chef['id']])->all();

                        foreach ($exp as $experiences => $key){

                            $key['status'] = 1;
                            $key->save(false);


                        }

                    }

                }


                $user = Yii::$app->user->id;
                $auth = new DbManager;
                $auth->init();
                $role = $auth->getRole('costumer');
                $roles = $auth->getRole('chef');
                $auth->revoke($roles,$user);
                $auth->assign($role, $user);

            }


            //==CHEF==




            foreach ($user_role as $role => $key){
                if($key->name == 'chef'){

                    $current_chef->full_address = $request->post('Chef')['full_address'];
                    $current_chef->about = $request->post('Chef')['about'];
                    $current_chef->id_language = $request->post('Chef')['id_language'];
                    $current_chef->id_countries = $request->post('Chef')['id_countries'];
                    $current_chef->save(false);

                    $fileName = $current_chef->full_address;

                    $model_chef->files = UploadedFile::getInstance($model_chef,'files');

                    if($model_chef->files == null){

                    }else{
                    $user_id = Yii::$app->user->identity->getId();

                    $path ='upload/chef/'.$user_id.'/';

                    $user_log = Yii::$app->user->getId();

                    $chef_profile = Chef::find()->where(['id_users' => $user_log])->one();
                    $chef_image = $chef_profile->files;

                    FileHelper::createDirectory($path);

                    $MainImageNew = uniqid() . '_image_' . $fileName . '.' . $model_chef->files->extension;


                    if(file_exists($path.$chef_image)){


                        if(!FileHelper::unlink($path.$chef_image)){

                            $model_chef->files->saveAs($path . $MainImageNew);

                            $model_chef->files = $path . $MainImageNew;
                            $current_chef->files = $model_chef->files;
                            $current_chef->save();


                        }


                    }else{

                        FileHelper::createDirectory($path);
                        if($model_chef->image == null){

                        }else {
                            $MainImageNew = uniqid() . '_image_' . $fileName . '.' . $model_chef->files->extension;

                            $model_chef->files->saveAs($path . $MainImageNew);

                            $model_chef->files = $path . $MainImageNew;
                            $current_chef->files = $model_chef->files;
                            $current_chef->save();
                        }
                    }
                  }
               }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'user_role'=>$user_role,
            'model_chef' =>$model_chef,
            'current_chef'=>$current_chef,
            'listDataLang' => $listDataLang,
            'listData' => $listData,
            'user_role' => $user_role
        ]);
    }


    /**
     * Finds the UserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
