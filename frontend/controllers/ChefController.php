<?php

namespace frontend\controllers;

use common\models\Country;
use common\models\Language;
use Yii;
use common\models\Chef;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ChefController implements the CRUD actions for Chef model.
 */
class ChefController extends LayoutController
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
                        'roles' => ['admin','chef'],
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
     * Lists all Chef models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Chef::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Chef model.
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
     * Updates an existing Chef model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $country = Country::find()->all();
        $listData = ArrayHelper::map($country,'id','name');

        $lang = Language::find()->all();
        $listDataLang = ArrayHelper::map($lang,'id','name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $fileName = $model->full_address;

            $model->files = UploadedFile::getInstance($model,'files');

            $user_id = Yii::$app->user->identity->getId();

            $path ='upload/chef/'.$user_id.'/';

            $user_log = Yii::$app->user->getId();

            $chef_profile = Chef::find()->where(['id_users' => $user_log])->one();
            $chef_image = $chef_profile->files;

            FileHelper::createDirectory($path);

            $MainImageNew = uniqid() . '_image_' . $fileName . '.' . $model->files->extension;



            if(file_exists($path.$chef_image)){


                if(!FileHelper::unlink($path.$chef_image)){



                    $model->files->saveAs($path . $MainImageNew);

                    $model->files = $path . $MainImageNew;

                    $model->save();

                }


            }else{

                FileHelper::createDirectory($path);

                $MainImageNew = uniqid() . '_image_' . $fileName . '.' . $model->files->extension;

                $model->files->saveAs($path . $MainImageNew);

                $model->files = $path . $MainImageNew;

                $model->save();

            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('_form', [
            'listDataLang' => $listDataLang,
            'listData' => $listData,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Chef model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chef model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chef the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chef::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
