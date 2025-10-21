<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int|null $author_id
 * @property string|null $content
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $is_deleted
 * @property string|null $link
 *
 * @property Author $author
 *
 */
class Post extends \yii\db\ActiveRecord
{

    public $author_posts_count;

    const TIME_EDIT = 43200; // 12 часов
    const TIME_DELETE = 1209600; // 14 дней

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'content', 'created_at', 'updated_at', 'link'], 'default', 'value' => null],
            [['is_deleted'], 'default', 'value' => 0],
            [['author_id', 'is_deleted'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['link'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],

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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'content' => 'Сообщение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
            'link' => 'Link',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery|AuthorQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * {@inheritdoc}
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }


    /**
     * @return Query
     */
    public static function findAllWithAuthor()
    {

        $data = Post::find()
            ->alias('p')
            ->select([
                'p.*', 'a.name', '(
                 SELECT COUNT(*)
                 FROM post p2
                 WHERE p2.author_id IN (SELECT id FROM author ar WHERE ip = a.ip)
                 ) AS author_posts_count '
            ])
            ->where(['p.is_deleted' => 0])
            ->innerJoin(['a' => Author::tableName()], 'a.id = p.author_id')
            ->orderBy(['p.created_at' => SORT_DESC])
            ->cache(false);

        return $data;

    }

    /**
     * Функция удаления(сокрытия) поста
     * @param string $link
     * @return bool
     */
    public static function remove(string $link): bool
    {
        $post = Post::findOne(['link' => $link]);
        $post->is_deleted = 1;
        if ($post->save()) {
            return true;
        }
        return false;
    }

}
