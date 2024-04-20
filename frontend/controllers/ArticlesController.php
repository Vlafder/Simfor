<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\Articles;
use frontend\models\Comments;
use frontend\models\Likes;
use common\models\User;

define("ArticlesPerPage", 1);

/**
 * Articles controller
 */
class ArticlesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex()
    {
        $page_num = 1;
        $page_count = (int)ceil((Articles::find()->count())/ArticlesPerPage);

        if( array_key_exists('page', Yii::$app->request->get()) )
        {
            $page_num   = Yii::$app->request->get()['page'];
            
            if($page_num>1 and $page_num<=$page_count)
                $articles = Articles::find()->limit(ArticlesPerPage)->offset(($page_num-1)*ArticlesPerPage)->all();
            else 
                return $this->redirect('/');
        }
        else
            $articles = Articles::find()->limit(ArticlesPerPage)->all();
        

        foreach ($articles as $article){
            $article->user_id =  User::find()  -> where( ['id' => $article->user_id] ) -> one() -> username;
        }

        return $this->render('articles', [
            'articles' => $articles,
            'pagenum'  => $page_num,
            'page_cnt' => $page_count
        ]);
    }


    public function actionArticle()
    {
        if(Yii::$app->request->isPost) 
        {
            if(Yii::$app->request->post()["NewComment"]['text'] != ""){
                $comment = new Comments();

                $comment->art_id  = Yii::$app->request->get()['id'];
                $comment->text    = substr(Yii::$app->request->post()["NewComment"]['text'],  0, 255);
                $comment->user_id = Yii::$app->user->id;
                $comment->date    = date('Y-m-d');

                $comment->save();
            }
            
            return $this->redirect(Yii::$app->getRequest()->getUrl());
        }

        $article    = Articles::find()->where( ['art_id' => Yii::$app->request->get()['id']] ) -> one();
        $comments   = Comments::find()->where( ['art_id' => Yii::$app->request->get()['id']] ) -> all();
        $liked = Likes::find() -> where( ['art_id' => $article->art_id, 'user_id'=>Yii::$app->user->id]) -> one();
                        if($liked == null)
                            $liked = false;
                        else
                            $liked = $liked->state;

        if($article==null){
            return $this->redirect('/');
        }

        $article->views += 1;
        $article->update();

        $article->user_id = User::find() -> where( ['id' => $article->user_id] ) -> one() -> username;

        foreach ($comments as $comment){
            $comment->user_id =  User::find() -> where( ['id' => $comment->user_id] ) -> one() -> username;
        }

        return $this->render('article', [
            'article'    => $article,
            'comments'   => $comments,
            'liked'      => $liked
        ]);
    }


    public function actionNew()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        }

        if(Yii::$app->request->isPost) 
        {            
            if(Yii::$app->request->post()["NewArticle"]['title'] != ""  and  Yii::$app->request->post()["NewArticle"]['text'] != ""){
                $article = new Articles();

                $article->title   = substr(Yii::$app->request->post()["NewArticle"]['title'], 0, 100);
                $article->text    = substr(Yii::$app->request->post()["NewArticle"]['text'],  0, 2000);
                $article->user_id = Yii::$app->user->id;
                $article->date    = date('Y-m-d');
                $article->likes   = 0;
                $article->views   = 0;

                $article->save();

                return $this->redirect('/articles/article?id='.$article->art_id);
            }
            
            return $this->redirect('/');
        }

        return $this->render('new');
    }


    public function actionLike() 
    {
        if (Yii::$app->user->isGuest) die();

        if(Yii::$app->request->isPost) { #POST request
            if(Yii::$app->request->post()["art_id"] != ""){ #contains art_id

                $art = Yii::$app->request->post()["art_id"];
                $article = Articles::find()->where([ 'art_id' => $art ])->one();
                if($article != null){ #article exists
                    $id  = Yii::$app->user->id;

                    $like = Likes::find()->where([ 'art_id' => $art, 'user_id' => $id ]) -> one();

                    if($like==null){
                        $like = new Likes();
                        $like->art_id = $art;
                        $like->user_id = $id;
                        $like->state = true;
                        $like->save();
                        $article->likes += 1;
                    }
                    else {
                        $like->state = !$like->state;
                        $like->update();
                        $article->likes += $like->state ? 1 : -1;
                    }

                    $article->update();
                }
            }
        }
    }
   
}
