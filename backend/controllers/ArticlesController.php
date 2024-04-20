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
class ArticlesController extends Controller
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
        $articles = Articles::find()->all(); 

        foreach ($articles as $article)
            $article->user_id = User::find()->where(['id'=>$article->user_id])->one()->username;

        return $this->render('articles', [
            'articles' => $articles
        ]);
    }



    public function actionArticle()
    {
        if( array_key_exists('id', Yii::$app->request->get()) ){
            $article = Articles::find()->where(['art_id'=>Yii::$app->request->get()['id']])->one(); 
            if($article!=null)
                return $this->render('article', ['article' => $article]);
        }

        return $this->redirect('/');
    }


    public function actionDelete()
    {
        if( array_key_exists('id', Yii::$app->request->get()) ){
            $art_id = Yii::$app->request->get()['id'];

            if(!Yii::$app->user->isGuest and User::find()->where(['id'=>Yii::$app->user->id])->one()->admin){
                
                    Articles::deleteAll(['art_id'=>$art_id]);
                    Comments::deleteAll(['art_id'=>$art_id]);
                    Likes::deleteAll(['art_id'=>$art_id]);
                
            }
        }

        return $this->redirect('/');
    }
    
}
