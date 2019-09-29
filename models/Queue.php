<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "queue".
 *
 * @property int $id
 * @property string $created_date
 * @property int $fail_count
 * @property string $message
 */
class Queue extends \yii\db\ActiveRecord
{
    const _TRY_NUM = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_date'], 'safe'],
            [['fail_count'], 'integer'],
            [['message'], 'required'],
            [['message'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_date' => 'Created Date',
            'fail_count' => 'Fail Count',
            'message' => 'Message',
        ];
    }

    /**
     *
     */
    public static function getNextQueue()
    {
        return self::find()
            ->where(['<', 'fail_count', self::_TRY_NUM])
            ->orderBy(['id' => SORT_ASC])
            ->one();
    }

    /**
     *
     */
    public function increaseFailCounter(): void
    {
        $this->setAttribute('fail_count', $this->getAttribute('fail_count') + 1);
        $this->save();
    }

    /**
     * @return int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deleteWithReturnId(): int
    {
        $id = $this->getAttribute('id');
        $this->delete();
        return $id;
    }
}
