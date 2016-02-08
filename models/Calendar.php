<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_calendar".
 *
 * @property integer $id
 * @property string $text
 * @property integer $creator
 * @property string $date_event
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_calendar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'date_event'], 'required'], //'creator'
            [['text'], 'string'],
            [['creator'], 'integer'],
            [['date_event'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'creator' => Yii::t('app', 'Creator'),
            'date_event' => Yii::t('app', 'Date Event'),
        ];
    }

    /**
     * Before save new note creator is current user
     * @param bool $insert
     * @return bool
     */
    public function beforeSave ($insert)
    {
        if ($this->getIsNewRecord())
        {
            $this->creator = Yii::$app->user->id;
        }
        parent::beforeSave($insert);
        return true;
    }

    public function getAccess(){
        return $this->hasMany(Access::className(), ['user_gest' => 'id', 'date' => 'date_event']);
    }

    public function getCreator(){
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    public static function allMyshedules($creator_id){
        return self::find()
                        ->withCreator($creator_id)
                        ->orderBy('date_event')
                        ->all();
    }

    /**
     * @inheritdoc
     * @return \app\models\query\CalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\CalendarQuery(get_called_class());
    }
}
