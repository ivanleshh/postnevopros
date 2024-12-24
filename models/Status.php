<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string $title
 *
 * @property Post[] $posts
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
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
        return $this->hasMany(Post::class, ['status_id' => 'id']);
    }

    public static function getStatusId($title)
    {
        return self::findOne(['title' => $title])->id;
    }

    public static function getStatuses($except = null)
    {
        $statuses = self::find()->select('title')->orderBy('id')->column();
        if (isset($except)) {
            unset($statuses[array_search($except, $statuses)]);
        }
        return $statuses;
    }
}
