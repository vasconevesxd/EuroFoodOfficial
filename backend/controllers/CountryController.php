<?php

namespace backend\controllers;

use common\models\Comment;
use Yii;
use common\models\Country;
use app\models\CountrySearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CountryController implements the CRUD actions for Country model.
 */
class CountryController extends Controller
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
     * Lists all Country models.
     * @return mixed
     */
    public function actionIndex()
    {

        $allcountries = (new \yii\db\Query())
            ->select(['country.id', 'country.name','country.image'])
            ->from('country')
            ->all();

        $allemptycountries = (new \yii\db\Query())
            ->select(['country.id'])
            ->from('country')
            ->leftJoin('experience_type','country.id=experience_type.id_countries')
            ->andWhere(['is', 'experience_type.id_countries', new \yii\db\Expression('null')])
            ->all();

        return $this->render('index', [
            'allcountries' => $allcountries,'allemptycountries' => $allemptycountries
        ]);

    }

    /**
     * Displays a single Country model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $deleterestricition = (new \yii\db\Query())
            ->select(['country.id'])
            ->from('country')
            ->leftJoin('experience_type','country.id=experience_type.id_countries')
            ->andWhere(['is', 'experience_type.id_countries', new \yii\db\Expression('null')])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'deleterestricition'=> $deleterestricition,
        ]);
    }

    /**
     * Creates a new Country model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Country();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $country = ArrayHelper::getValue(Yii::$app->request->post(), 'Country.name');
            $the_country = Country::find()->where(['name'=>$country])->one();

            if($the_country == null){

                $fileName = $model->name;

                $model->image = UploadedFile::getInstance($model,'image');

                if($model->image == null){

                }else{
                    $path = Url::to('@frontend/web/upload/country_upload/');
                    $model->image->saveAs($path.$fileName.'.'.$model->image->extension);

                    //save the path in the db column
                    $model->image = 'upload/country_upload/'.$fileName.'.'.$model->image->extension;
                    $model->save();

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Country model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $counties = Country::find()->where(['id' => $id])->one();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $country = ArrayHelper::getValue(Yii::$app->request->post(), 'Country.name');
            $the_country = Country::find()->where(['name'=>$country])->one();

            if($the_country == null) {

                $fileName = $model->name;

                if (file_exists($counties->image) || $counties->name != $fileName) {

                    $path = Url::to('@frontend/web/upload/country_upload/');
                    $model->image = UploadedFile::getInstance($model, 'image');

                    if($model->image == null){

                    }else{

                    $path_unlink = Url::to('@frontend/web/');
                    FileHelper::unlink($path_unlink.$counties->image);


                    $model->image->saveAs($path . $fileName . '.' . $model->image->extension);

                    //save the path in the db column
                    $model->image = 'upload/country_upload/' . $fileName . '.' . $model->image->extension;
                    $model->save();

                    }

                } else {


                    $model->image = UploadedFile::getInstance($model, 'image');

                    if($model->image == null){

                    }else {

                        $path = Url::to('@frontend/web/upload/country_upload/');
                        $model->image->saveAs($path . $fileName . '.' . $model->image->extension);

                        //save the path in the db column
                        $model->image = 'upload/country_upload/' . $fileName . '.' . $model->image->extension;
                        $model->save();

                    }

                }
                return $this->redirect(['view', 'id' => $model->id]);

            }

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Country model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $country = Country::find()->where(['id'=>$id])->one();

        unlink(Url::to('@frontend/web/').$country['image']);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Country model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Country the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Country::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
