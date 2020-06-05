<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\ExperienceType;
use common\models\Likes;
use common\models\Meal;
use Yii;
use common\models\Order;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends LayoutController
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
                        'actions' => ['index','create','update','view','delete','comment','like','dislike'],
                        'roles' => ['admin','chef','costumer'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','create'],
                        'roles' => ['?'],
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


    public function actionView($id)
    {
        $model = $this->findModel($id);

        $order = Order::find()->where(['id' => $id])->one();

        $experience_type = ExperienceType::find()->where(['id' => $order->id_experiences_type])->one();

        $final_price  =  $experience_type->price+( $experience_type->price* $order->guest_number);

        $all_images = $experience_type->images;

        $images = explode(',', $all_images);


        return $this->render('view', [
            'model'=>$model,
            'experience_type' => $experience_type,
            'order' => $order,
            'images' => $images,
            'final_price' => $final_price
        ]);
    }


    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {


        $model = new Order();

        $model_comment = new Comment();

        $dataProvider = (new \yii\db\Query())
            ->select(['user_profile.image','user.username','comment.comments','comment.create_at'])
            ->from('comment')
            ->leftJoin('user_profile', 'comment.id_users = user_profile.id_users')
            ->leftJoin('user', 'user_profile.id_users = user.id')
            ->where(['id_experiences_type' => $id])
            ->orderBy(['comment.create_at' => SORT_DESC])
            ->all();

        $user_image = (new \yii\db\Query())
            ->select(['user_profile.image','user.username'])
            ->from('comment')
            ->rightJoin('user', 'comment.id_users=comment.id')
            ->rightJoin('user_profile', 'user.id=user_profile.id_users')
            ->where(['user.id' => Yii::$app->user->identity])
            ->one();




        $experience_type = ExperienceType::find()->where(['id' => $id])->one();

        $meal = Meal::find()->where(['id' => $experience_type->id_meal])->one();

        $all_images = $experience_type->images;

        $images = explode(',', $all_images);

        $model->id_user = Yii::$app->user->getId();

        $model->id_experiences_type = $id;

        $model->data_order = date("Y-m-d H:i:s");

        $resp_exp = Yii::$app->request->post();

        $the_data = ArrayHelper::getValue($resp_exp, 'Order.experience_time');

        $check_order = (new \yii\db\Query())
            ->select(['user.id','`order`.id_user','`order`.experience_time'])
            ->from('user')
            ->innerJoin('`order`', 'user.id=`order`.id_user')
            ->where(['and',['`order`.id_experiences_type'=>$id, '`order`.experience_time' => $the_data]])
            ->all();



               if ($model->load(Yii::$app->request->post()) && $model->save()) {


                $data_request = Yii::$app->request->post();

                $data_order = $data_request['Order'];

                $orders = $data_order['experience_time'];

                $order_time = strtotime($orders);

                $data = date("Y/m/d");
                $data_now = strtotime($data);


                if ($order_time < $data_now and $orders == null and $check_order != null) {


                } else if ($order_time > $data_now and $orders != null and $check_order == null) {

                    return $this->redirect(['order/view', 'id' => $model->id]);

                }

        }



        $user_exis_exp = (new \yii\db\Query())
            ->select(['user.id','experience_type.id','likes.id_experiences_type','likes.dislike','likes.n_like'])
            ->from('user')
            ->innerJoin('likes', 'user.id=likes.id_user')
            ->innerJoin('experience_type', 'experience_type.id=likes.id_experiences_type')
            ->where(['and',['user.id' => Yii::$app->user->getId(), 'likes.id_experiences_type'=>$id]])
            ->one();


        return $this->render('create',['model'=>$model,'user_exis_exp'=>$user_exis_exp, 'model_comment'=>$model_comment,'user_image'=>$user_image, 'dataProvider'=>$dataProvider, 'experience_type'=>$experience_type, 'meal'=>$meal, 'images'=>$images]);

    }


    public function actionLike(){

        $heads = Yii::$app->request->headers;

        $path_parts = explode('id',$heads["referer"]);
        $search = '=' ;
        $id = str_replace($search, '', $path_parts[1]) ;

        $user_exis_exp = (new \yii\db\Query())
            ->select(['user.id','experience_type.id','likes.id_experiences_type','likes.dislike','likes.n_like','experience_type.likes_total'])
            ->from('user')
            ->innerJoin('likes', 'user.id=likes.id_user')
            ->innerJoin('experience_type', 'experience_type.id=likes.id_experiences_type')
            ->where(['and',['user.id' => Yii::$app->user->getId(), 'likes.id_experiences_type'=>$id]])
            ->one();

        if($user_exis_exp == null){

            $model = new Likes();
            $model->n_like = 1;
            $model->id_user = Yii::$app->user->getId();
            $model->id_experiences_type = $id;
            $model->dislike = 0;
            $model->save(false);

        }else{
            if($user_exis_exp['n_like'] == 1){

                $the_like= Likes::find()->where(['and',['id_experiences_type' => $id, 'id_user' => Yii::$app->user->getId()]])->one();
                $the_like->n_like = $the_like->n_like - 1;
                $the_like->save(false);


            }else if($user_exis_exp['n_like'] == 0){
                $the_like= Likes::find()->where(['and',['id_experiences_type' => $id, 'id_user' => Yii::$app->user->getId()]])->one();
                $the_like->n_like  = $the_like->n_like  + 1;
                $the_like->save(false);

            }

            if($user_exis_exp['dislike'] == 1){
                $the_like= Likes::find()->where(['and',['id_experiences_type' => $id, 'id_user' => Yii::$app->user->getId()]])->one();
                $the_like->dislike  = 0;
                $the_like->save(false);

            }
        }

        $total_likes = Likes::find()->where(['id_experiences_type' => $id])->all();


        $total = 0;

        foreach ($total_likes as $likes => $value) {
            $total = $value['n_like'] + $total;

        }

        $the_experience = ExperienceType::findOne($id);


        $the_experience->likes_total = $total;

        $the_experience->save(false);

        return $this->redirect(['order/create', 'id' => $id]);

    }


    public function actionDislike(){

        $heads = Yii::$app->request->headers;
        $path_parts=explode('id',$heads["referer"]);
        $search = '=' ;
        $id = str_replace($search, '', $path_parts[1]) ;

        $user_exis_exp = (new \yii\db\Query())
            ->select(['user.id','experience_type.id','likes.id_experiences_type','likes.dislike','likes.n_like'])
            ->from('user')
            ->innerJoin('likes', 'user.id=likes.id_user')
            ->innerJoin('experience_type', 'experience_type.id=likes.id_experiences_type')
            ->where(['and',['user.id' =>Yii::$app->user->getId(), 'likes.id_experiences_type'=>$id]])
            ->one();

        if($user_exis_exp == null){

            $model = new Likes();
            $model->dislike = 1;
            $model->id_user = Yii::$app->user->getId();
            $model->id_experiences_type = $id;
            $model->n_like = 0;
            $model->save(false);

        }else{
            if($user_exis_exp['dislike'] == 1){
                $the_like= Likes::find()->where(['and',['id_experiences_type' => $id, 'id_user' => Yii::$app->user->getId()]])->one();
                $the_like->dislike = $the_like->dislike - 1;
                $the_like->save(false);


            }else if($user_exis_exp['dislike'] == 0){
                $the_like= Likes::find()->where(['and',['id_experiences_type' => $id, 'id_user' => Yii::$app->user->getId()]])->one();
                $the_like->dislike  = $the_like->dislike  + 1;
                $the_like->save(false);
            }

            if($user_exis_exp['n_like'] == 1){

                $the_like= Likes::find()->where(['and',['id_experiences_type' => $id, 'id_user' => Yii::$app->user->getId()]])->one();
                $the_like->n_like  = 0;
                $the_like->save(false);

            }
        }


        return $this->redirect(['order/create', 'id' => $id]);

    }



    public function actionComment()
    {

        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = Response::FORMAT_JSON;

            $model_comment = new Comment();
            $model_comment->comments = Yii::$app->request->post('comments');
            $model_comment->id_experiences_type = Yii::$app->request->post('id_experience');
            $model_comment->id_users = Yii::$app->user->getId();
            $model_comment->create_at = date('Y-m-d h:i:sa');
            $model_comment->save(false);

            $commentes = Comment::find()->where(['id_users' => Yii::$app->user->id])->all();
            $comment = $commentes;

            return [
                'check' => Yii::$app->request->post('comments'),
                'comment' => $comment,
            ];

        }

    }


    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $experience_type = ExperienceType::find()->where(['id' => $id])->one();

        $all_images = $experience_type->images;

        $images = explode(',', $all_images);

        $model->id_experiences_type = $id;
        $model->save();

        $model->data_order = date("Y-m-d H:i:s");
        $model->save();


        $user_id = Yii::$app->user->getId();
        $convert_id = strval($user_id);
        $model->id_user = $convert_id;
        $model->save();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['payment/create', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'experience_type' => $experience_type,
            'images' => $images
        ]);
    }

    /**
     * Deletes an existing Order model.
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
