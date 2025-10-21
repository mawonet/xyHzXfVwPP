<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Post;
use app\models\PostForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Отображение главной
     * @return Response|string
     */
    public function actionIndex()
    {

        $posts = Post::find()->with('author')->asArray()->all();

        $modelPostCreate = new PostForm();

        if ($modelPostCreate->load(Yii::$app->request->post())) {
            if ($modelPostCreate->save()) {
                $this->sendRegisterMail();
                return $this->refresh();
            }
        }

        return $this->render('index', [
            'modelPost' => $modelPostCreate,
            'posts' => $posts,
        ]);
    }

    /**
     * Отображение обновления.
     *
     * @return Response|string
     */
    public function actionUpdate($link)
    {

        $post = Post::find()->with('author')->andWhere(['and',
            ['link' => $link],
            ['is_deleted' => 0],
            ['>=', 'created_at', time() - POST::TIME_EDIT]
        ])->one();

        if (Yii::$app->request->post()) {
            $post->content = Yii::$app->request->post()['Post']['content'];
            $post->updated_at = time();
        }

        if ($post->save()) {
            return $this->render('update', [
                'model' => $post,
            ]);
        } else {
            return $this->render('error');
        }
    }

    /**
     * Отображение страницы удаления
     *
     * @return Response|string
     */
    public function actionDelete($link)
    {
        $post = Post::find()->andWhere(['and',
            ['link' => $link],
            ['is_deleted' => 0],
            ['>=', 'created_at', time() - POST::TIME_DELETE]
        ])->one();
        if ($post) {
            return $this->render('delete', [
                'post' => $post,
            ]);
        } else {
            return $this->render('error');
        }
    }

    /**
     * Метод мнимого удаления
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionRemove()
    {
        if (Yii::$app->request->isPost) {

            $link   = Yii::$app->request->post('link');
            $post   = Post::findOne(['link' => $link]);
            $isTime = ($post->created_at >= (time() - POST::TIME_DELETE));

            if ($post && $isTime) {
                $post->is_deleted = 1;
                if($post->save()) {
                    return json_encode(['status' => 'success'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return json_encode(['status' => false]);
            }
        } else {
            return json_encode(['status' => false]);
        }
    }

    /*
     * Метод отправки регистрационного письма
     */
    private function sendRegisterMail(): void
    {
        $lastRecord = Post::find()
            ->orderBy(['id' => SORT_DESC])
            ->with('author')
            ->one();
        $linkUpdate = 'http://xyhzxfvwpp/web/update?link='.$lastRecord->link;;
        $body = 'Cсылка для редактирования: '. $linkUpdate . '<br>';

        $linkDelete = 'http://xyhzxfvwpp/web/delete?link='.$lastRecord->link;
        $body .= 'Ссылка для удаления: '. $linkDelete . '<br>';



        Yii::$app->mailer->compose()
            ->setFrom('example@example.com')
            ->setTo($lastRecord->author->email)
            ->setSubject('Оправка сообщения StoryValut')
            ->setHtmlBody($body)
            ->setCharset('utf-8')
            ->send();
    }

}
