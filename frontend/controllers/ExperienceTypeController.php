<?php

namespace frontend\controllers;


use common\models\Chef;
use common\models\Country;
use common\models\Meal;
use common\models\Order;
use common\models\User;
use Yii;
use common\models\ExperienceType;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ExperienceTypeController implements the CRUD actions for ExperienceType model.
 */
class ExperienceTypeController extends LayoutController
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
                        'actions' => ['index','view','create','update','delete','list-experience'],
                        'roles' => ['chef'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['list-experience'],
                        'roles' => ['?','costumer','admin'],
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
     * Lists all ExperienceType models.
     * @return mixed
     */
    public function actionIndex()
    {

        $current_chef = Chef::find()->where(['id_users'=>Yii::$app->user->id])->one();

        $allexperience = (new \yii\db\Query())
            ->select(['*'])
            ->from('experience_type')
            ->where(['id_chef'=>$current_chef->id])
            ->all();

        $allemptyexperiences = (new \yii\db\Query())
            ->select(['experience_type.id'])
            ->from('experience_type')
            ->leftJoin('`order`','experience_type.id=`order`.id_experiences_type')
            ->leftJoin('comment','experience_type.id=comment.id_experiences_type')
            ->leftJoin('likes','experience_type.id=likes.id_experiences_type')
            ->andWhere(['and', ['`order`.id_experiences_type' => null],['comment.id_experiences_type' => null],['likes.id_experiences_type' => null]])
            ->all();


        return $this->render('index', [
            'allexperience' => $allexperience,
            'allemptyexperiences' => $allemptyexperiences,
        ]);
    }

    /**
     * Displays a single ExperienceType model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $deleterestricition = (new \yii\db\Query())
            ->select(['experience_type.id'])
            ->from('experience_type')
            ->leftJoin('`order`','experience_type.id=`order`.id_experiences_type')
            ->leftJoin('comment','experience_type.id=comment.id_experiences_type')
            ->leftJoin('likes','experience_type.id=likes.id_experiences_type')
            ->andWhere(['and', ['`order`.id_experiences_type' => null],['comment.id_experiences_type' => null],['likes.id_experiences_type' => null]])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'deleterestricition' => $deleterestricition,
        ]);
    }

    /**
     * Creates a new ExperienceType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new ExperienceType();

        $chefs = Chef::find()->where(['id_users'=>Yii::$app->user->getId()])->one();

        $model->id_chef = $chefs['id'];

        $meals = Meal::find()->all();
        $listDataMeal = ArrayHelper::map($meals,'id','name');


        $countries = Country::find()->all();
        $listDataCountry = ArrayHelper::map($countries,'id','name');

        $model->status = 1;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $model->images = UploadedFile::getInstances($model, "images");

            $username = Yii::$app->user->identity->username;

            $path_user = 'upload/experience_upload/' . $username . '/';

            if(!file_exists($path_user)) {

                FileHelper::createDirectory($path_user);
            }

            $path_title = $path_user.$model->title.'/';

            if(!file_exists($path_title)) {

                FileHelper::createDirectory($path_title);

            }

            if(file_exists($path_user) and file_exists($path_title)){

                $document = [];
                foreach ($model->images as $file) {

                    $MainImageNew = uniqid() . '_image_' . $model->title . '.' . $file->extension;
                    $file->saveAs($path_title . $MainImageNew);
                    $document[] = $path_title . $MainImageNew;
                }

                $model->images = implode(',', $document);


                $model->save();


                return $this->redirect(['view', 'id' => $model->id]);

            }
        }

        return $this->render('_form', [
            'listDataMeal' => $listDataMeal,
            'listDataCountry' => $listDataCountry,
            'model' => $model
        ]);
    }


    /**
     * Updates an existing ExperienceType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $meals = Meal::find()->all();
        $listDataMeal = ArrayHelper::map($meals,'id','name');


        $countries = Country::find()->all();
        $listDataCountry = ArrayHelper::map($countries,'id','name');


        $experience = ExperienceType::find()->where(['id' => $id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $model->images = UploadedFile::getInstances($model, "images");


            $experience_image = $experience->images;

            $images = explode(',', $experience_image);


            foreach ($images as $img){

                FileHelper::unlink($img);

            }



            $username = Yii::$app->user->identity->username;

            $path_user = 'upload/experience_upload/'.$username.'/';

            if(!file_exists($path_user)) {

                FileHelper::createDirectory($path_user);

            }


            $path_exp = "upload/experience_upload/".Yii::$app->user->identity->username."/".$experience['title'];

            if(!file_exists($path_exp)) {

                FileHelper::createDirectory($path_exp);

            }

            $path_title = $path_user.$model->title.'/';


            if($model->title != $experience['title']){

                FileHelper::removeDirectory($path_exp);

                FileHelper::createDirectory($path_title);

            }


            $document = [];
            foreach ($model->images as $file) {



                $MainImageNew = uniqid() . '_image_' . $model->title . '.' . $file->extension;
                $file->saveAs($path_title . $MainImageNew);
                $document[] = $path_title . $MainImageNew;
            }
            $model->images = implode(',', $document);


            $model->save();



            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form', [
            'listDataMeal' => $listDataMeal,
            'listDataCountry'=>$listDataCountry,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExperienceType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $experience = ExperienceType::find()->where(['id' => $id])->one();

        $experience_image = $experience->images;

        $images = explode(',', $experience_image);

        foreach ($images as $img) {

            FileHelper::unlink($img);

        }

        $experiences = (new \yii\db\Query())
            ->select(['user.username','experience_type.title'])
            ->from('experience_type')
            ->leftJoin('chef', 'experience_type.id_chef=chef.id')
            ->leftJoin('user', 'chef.id_users=user.id')
            ->where(['experience_type.id' => $id])
            ->one();

        FileHelper::removeDirectory('upload/experience_upload/'.$experiences['username'].'/'.$experiences['title']);



        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function  actionListExperience($id){


        $this->layout = "main";

        $experiences = (new \yii\db\Query())
            ->select(['experience_type.id','experience_type.images','experience_type.id_countries', 'experience_type.price','experience_type.likes_total', 'experience_type.title', 'user_profile.image'])
            ->from('experience_type')
            ->leftJoin('chef', 'experience_type.id_chef=chef.id')
            ->leftJoin('user', 'chef.id_users=user.id')
            ->leftJoin('user_profile', 'user.id=user_profile.id_users')
            ->where(['and',['experience_type.status' => 2],['experience_type.id_countries' => $id]])
            ->all();



        return $this->render('list_experience',['experiences'=>$experiences]);
    }


    /**
     * Finds the ExperienceType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExperienceType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExperienceType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
