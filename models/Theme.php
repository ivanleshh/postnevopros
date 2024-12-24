<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "theme".
 *
 * @property int $id
 * @property string $title
 *
 * @property Post[] $posts
 */
class Theme extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'theme';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Posts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['theme_id' => 'id']);
    }

    public static function getThemes()
    {
        return (new Query())->select('title')->from(self::tableName())->indexBy('id')->column();
    }
}
