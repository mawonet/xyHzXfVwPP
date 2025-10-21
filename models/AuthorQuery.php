<?php


namespace app\models;

/**
 * This is the ActiveQuery class for [[Author]].
 *
 * @see Author
 */
class AuthorQuery extends \yii\db\ActiveQuery
{
    /**
     * {@inheritdoc}
     * @return Author[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Author|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
