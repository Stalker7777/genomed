<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hrefshort".
 *
 * @property int $id
 * @property string $href_long
 * @property string $href_short
 * @property string $qr_image
 *
 * @property Counter[] $counters
 */
class Hrefshort extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hrefshort';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['href_long', 'href_short', 'qr_image'], 'required'],
            [['href_long'], 'string', 'max' => 1000],
            [['href_short'], 'string', 'max' => 50],
            [['qr_image'], 'string', 'max' => 255],
            ['href_long', 'url', 'defaultScheme' => 'http'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'href_long' => 'Введите ссылку',
            'href_short' => 'Href Short',
            'qr_image' => 'Qr Image',
        ];
    }

    /**
     * Gets query for [[Counters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCounters()
    {
        return $this->hasMany(Counter::class, ['hrefshort_id' => 'id']);
    }

}
