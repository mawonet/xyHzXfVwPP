<?php

namespace app\models;

use app\models\Author;
use Yii;
use yii\base\Model;
use app\models\Post;

class PostForm extends Model
{
    public $name;
    public $email;
    public $content;
    public $link;
    public $verifyCode;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'email', 'content'], 'required'],
            ['email', 'email'],
            ['verifyCode', 'captcha'],
            ['name', 'string', 'min' => 2, 'max' => 15],
            ['content', 'string', 'min' => 5, 'max' => 1000],
            ['content', 'filter', 'filter' => 'trim'],
            ['content', 'filter', 'filter' => function ($value) {
                $config = \HTMLPurifier_Config::createDefault();
                $config->set('HTML.AllowedElements', ['b','i','s']);
                $config->set('HTML.AllowedAttributes', []);
                $purifier = new \HTMLPurifier($config);
                return trim($purifier->purify($value));
            }],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя автора',
            'email' => 'Email',
            'content' => 'Сообщение',
            'verifyCode' => 'Код с картинки:',
        ];
    }

    /**
     * @return boolean
     */
    public function save(): bool
    {
        if ($this->validate()) {

            $author = Author::find()->where(['email' => $this->email])->one();
            $ip = Yii::$app->request->userIP;
            $checkAuthorIP = Author::find()->select('id')->where(['ip' => $ip])->orderBy(['id' => SORT_DESC])->one();

            if ($author == null) {
                $author = new Author();

                $author->name = $this->name;
                $author->email = $this->email;
                $author->ip = $ip;
                $author->save();
            }
            $post = new Post([
                'content' => $this->content,
                'author_id' => $author->id,
                'created_at' => time(),
                'updated_at' => time(),
                'link' => uniqid()
            ]);

            $checkTimeLastPost = Post::find()->select('created_at')->where(['author_id' => $checkAuthorIP->id])->orderBy(['created_at' => SORT_DESC])->one();


            if ($checkTimeLastPost && (($checkTimeLastPost->created_at + 180) > time())) {
                $buffer = $checkTimeLastPost->created_at + 180 - time();
                Yii::$app->session->setFlash('error', 'Произошла ошибка сохранения. Повторите через: ' . $buffer . ' c.');
                return false;
            } else {
                $post->save();
                return true;
            }

        }
        return false;
    }

}