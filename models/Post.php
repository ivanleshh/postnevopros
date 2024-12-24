<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string $title
 * @property int $theme_id
 * @property string|null $photo
 * @property string $created_at
 * @property int $user_id
 * @property string $text
 * @property int $status_id
 * @property string $created_at
 * @property string preview 
* @property string|null $cancel_reason
 * @property Status $status
 * @property Theme $theme
 * @property User $user

 */
class Post extends \yii\db\ActiveRecord
{
    const SCENARIO_THEME = 'theme';
    const SCENARIO_OTHER = 'other';
    const SCENARIO_CANCEL = 'cancel';
    public $check = false;
    public $imageFile; 
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
            [['title', 'text', 'preview'], 'required'],
            [['theme_id'], 'integer'],
            [['created_at', 'updated_at', 'status_id', 'like', 'dislike'], 'safe'],
            [['text'], 'string'],
            [['title', 'photo', 'other_theme', 'cancel_reason'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Theme::class, 'targetAttribute' => ['theme_id' => 'id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],

            ['check', 'boolean'],
            ['theme_id', 'required', 'on' => self::SCENARIO_THEME],
            ['other_theme', 'required', 'on' => self::SCENARIO_OTHER],
            ['cancel_reason', 'required', 'on' => self::SCENARIO_CANCEL]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'название (тема)',
            'theme_id' => 'тема поста',
            'photo' => 'изображение для поста',
            'created_at' => 'дата создания',
            'updated_at' => 'дата обновления',
            'user_id' => 'автор',
            'text' => 'текст поста',
            'status_id' => 'статус',
            'cancel_reason' => 'Причина запрета',
            'check' => 'Другая',
            'other_theme' => 'своя тема поста',
            'preview' => 'превью поста',
            'imageFile' => 'изображение для поста',
        ];
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Theme]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Theme::class, ['id' => 'theme_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLikes()
    {
        return $this->hasMany(Reaction::class, ['post_id' => 'id'])->andWhere(['reaction' => '1']);
    }

    public function getDislikes()
    {
        return $this->hasMany(Reaction::class, ['post_id' => 'id'])->andWhere(['reaction' => '-1']);
    }

    public function getComment()
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = Yii::$app->user->id 
            . '_' . time(). '_' . Yii::$app->security->generateRandomString() 
            . '.' . $this->imageFile->extension; 
            $this->imageFile->saveAs('img/' . $fileName);
            $this->photo = $fileName;
            return true;
        } else {
            return false;
        }
    }
}
