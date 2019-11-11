<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_unsur".
 *
 * @property int $kd_unsur
 * @property string $name
 *
 * @property RefSubUnsur[] $refSubUnsurs
 */
class RefUnsur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_unsur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_unsur'], 'required'],
            [['kd_unsur'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['kd_unsur'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_unsur' => 'Kd Unsur',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefSubUnsurs()
    {
        return $this->hasMany(RefSubUnsur::className(), ['kd_unsur' => 'kd_unsur']);
    }
}
