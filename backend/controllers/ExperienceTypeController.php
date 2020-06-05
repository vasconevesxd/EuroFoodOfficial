<?php

namespace backend\controllers;

use common\models\Chef;
use common\models\Country;
use common\models\Meal;
use common\models\User;
use Yii;
use common\models\ExperienceType;
use app\models\ExperienceTypeSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ExperienceTypeController implements the CRUD actions for ExperienceType model.
 */
class ExperienceTypeController extends Controller
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
                        'actions' => ['index','view','create','update','delete'],
                        'roles' => ['admin'],
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
        $experiencess = ExperienceType::find()->all();

        $allexperience = (new \yii\db\Query())
            ->select(['*'])
            ->from('experience_type')
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
            'experiencess' => $experiencess,
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
     */
    public function actionCreate()
    {
        $model = new ExperienceType();

        $meals = Meal::find()->all();
        $listDataMeal = ArrayHelper::map($meals,'id','name');

        $countries = Country::find()->all();
        $listDataCountry = ArrayHelper::map($countries,'id','name');

        $chef = Chef::find()->all();
        $listDataChef = ArrayHelper::map($chef,'id','id');

        $model->status = 1;


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {


            $model->images = UploadedFile::getInstances($model, "images");

            if($model->images == null){

            }else{

                $the_data = ArrayHelper::getValue(Yii::$app->request->post(), 'ExperienceType.id_chef');

                $current_chef = Chef::find()->where(['id'=>$the_data])->one();

                $current_user = User::find()->where(['id'=>$current_chef['id_users']])->one();


                $path_user = Url::to('@frontend/web/upload/experience_upload/'.$current_user['username'].'/');

                $path_user_db = Url::to('upload/experience_upload/'.$current_user['username'].'/');

                if(!file_exists($path_user)) {

                    FileHelper::createDirectory($path_user);
                }

                $path_title = $path_user.$model->title.'/';

                if(!file_exists($path_title)) {

                    FileHelper::createDirectory($path_title);

                }

                $path_title_db = $path_user_db.$model->title.'/';


                if (file_exists($path_user) and file_exists($path_title)){

                    $document = [];
                    foreach ($model->images as $file) {

                        $MainImageNew = uniqid() . '_image_' . $model->title . '.' . $file->extension;
                        $file->saveAs($path_title . $MainImageNew);
                        $document[] = $path_title_db . $MainImageNew;
                    }

                    $model->images = implode(',', $document);


                    $model->save();


                    return $this->redirect(['view', 'id' => $model->id]);

                }

            }
        }

        return $this->render('_form', [
            'listDataMeal' => $listDataMeal,
            'listDataChef' => $listDataChef,
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
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $stat_exp = ExperienceType::find()->where(['id'=>$id])->one();
        $model->status = $stat_exp['status'];


        $meals = Meal::find()->all();
        $listDataMeal = ArrayHelper::map($meals,'id','name');

        $countries = Country::find()->all();
        $listDataCountry = ArrayHelper::map($countries,'id','name');

        $chef = Chef::find()->all();
        $listDataChef = ArrayHelper::map($chef,'id','id');




        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $status = ArrayHelper::getValue(Yii::$app->request->post(), 'ExperienceType.status');
            $model->status = $status;


            $model->images = UploadedFile::getInstances($model, "images");

            if($model->images == null){

            }else {

                $experience = ExperienceType::find()->where(['id' => $id])->one();

                $experience_image = $experience->images;

                $images = explode(',', $experience_image);

                foreach ($images as $img) {

                    FileHelper::unlink(Url::to('@frontend/web/').$img);

                }


                $the_data = ArrayHelper::getValue(Yii::$app->request->post(), 'ExperienceType.id_chef');

                $current_chef = Chef::find()->where(['id'=>$the_data])->one();

                $current_user = User::find()->where(['id'=>$current_chef['id_users']])->one();


                $path_user = Url::to('@frontend/web/upload/experience_upload/'.$current_user['username'].'/');

                $path_user_db = Url::to('upload/experience_upload/'.$current_user['username'].'/');


                if(!file_exists($path_user)) {

                    FileHelper::createDirectory($path_user);
                }

                $path_title = Url::to('@frontend/web/upload/experience_upload/'.$current_user['username'].'/'.$model->title.'/');



                if(!file_exists($path_title)) {

                    FileHelper::createDirectory($path_title);

                }

                if($model->title != $experience['title']){

                    FileHelper::removeDirectory(Url::to("@frontend/web/upload/experience_upload/".$current_user['username']."/".$experience['title']));

                    FileHelper::createDirectory($path_title);

                }

                $path_title_db = $path_user_db.$model->title.'/';



                $document = [];
                foreach ($model->images as $file) {


                    $MainImageNew = uniqid() . '_image_' . $model->title . '.' . $file->extension;
                    $file->saveAs($path_title . $MainImageNew);
                    $document[] = $path_title_db . $MainImageNew;
                }

                $model->images = implode(',', $document);


                $model->save();


                return $this->redirect(['view', 'id' => $model->id]);

            }
        }

        return $this->render('_form', [
            'listDataChef' => $listDataChef,
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

            FileHelper::unlink(Url::to('@frontend/web/').$img);

        }

        $experiences = (new \yii\db\Query())
            ->select(['user.username','experience_type.title'])
            ->from('experience_type')
            ->leftJoin('chef', 'experience_type.id_chef=chef.id')
            ->leftJoin('user', 'chef.id_users=user.id')
            ->where(['experience_type.id' => $id])
            ->one();

        FileHelper::removeDirectory(Url::to('@frontend/web/upload/experience_upload/'.$experiences['username'].'/'.$experiences['title']));


        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
