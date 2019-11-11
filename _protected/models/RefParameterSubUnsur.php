<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_parameter_sub_unsur".
 *
 * @property int $id
 * @property int $kd_unsur
 * @property int $kd_sub_unsur
 * @property int $level
 * @property string $parameter
 *
 * @property RefSubUnsur $kdUnsur
 */
class RefParameterSubUnsur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_parameter_sub_unsur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_unsur', 'kd_sub_unsur', 'level'], 'required'],
            [['kd_unsur', 'kd_sub_unsur', 'level'], 'integer'],
            [['parameter'], 'string', 'max' => 255],
            [['kd_unsur', 'kd_sub_unsur'], 'exist', 'skipOnError' => true, 'targetClass' => RefSubUnsur::className(), 'targetAttribute' => ['kd_unsur' => 'kd_unsur', 'kd_sub_unsur' => 'kd_sub_unsur']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kd_unsur' => 'Kd Unsur',
            'kd_sub_unsur' => 'Kd Sub Unsur',
            'level' => 'Level',
            'parameter' => 'Parameter',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdUnsur()
    {
        return $this->hasOne(RefSubUnsur::className(), ['kd_unsur' => 'kd_unsur', 'kd_sub_unsur' => 'kd_sub_unsur']);
    }
}
