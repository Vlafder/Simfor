<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

use backend\models\Articles;
use backend\models\Comments;
use backend\models\Likes;
use common\models\User;

/**
 * Articles controller
 */
class UsersController extends Controller
{
    
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
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
                'class' => \yii\web\ErrorAction::class,
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
        $users = User::find()->all(); 

        return $this->render('users', [
            'users' => $users
        ]);
    }



    public function actionUser()
    {
        if( array_key_exists('id', Yii::$app->request->get()) ){
            $user = User::find()->where(['id'=>Yii::$app->request->get()['id']])->one(); 
            if($user!=null)
                return $this->render('user', ['user' => $user]);
        }

        return $this->redirect('/users');
    }


    public function actionDelete()
    {
        if( array_key_exists('id', Yii::$app->request->get()) ){
            $id = Yii::$app->request->get()['id'];

            if(!Yii::$app->user->isGuest and User::find()->where(['id'=>Yii::$app->user->id])->one()->admin){
                    User::deleteAll(['id'=>$id]);
                    Articles::deleteAll(['user_id'=>$id]);
                    Comments::deleteAll(['user_id'=>$id]);
                    Likes::deleteAll(['user_id'=>$id]);
            }
        }

        return $this->redirect('/users');
    }
    
}
