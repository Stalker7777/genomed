<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "counter".
 *
 * @property int $id
 * @property int $hrefshort_id
 * @property string $ip
 * @property int $count
 *
 * @property Hrefshort $hrefshort
 */
class Counter extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'counter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hrefshort_id', 'ip', 'count'], 'required'],
            [['hrefshort_id', 'count'], 'integer'],
            [['ip'], 'string', 'max' => 50],
            [['hrefshort_id'], 'exist', 'skipOnError' => true, 'targetClass' => Hrefshort::class, 'targetAttribute' => ['hrefshort_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hrefshort_id' => 'Hrefshort ID',
            'ip' => 'Ip',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[Hrefshort]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHrefshort()
    {
        return $this->hasOne(Hrefshort::class, ['id' => 'hrefshort_id']);
    }

}
