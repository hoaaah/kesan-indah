<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_sub_unsur".
 *
 * @property int $id
 * @property int $kd_unsur
 * @property int $kd_sub_unsur
 * @property string $name
 *
 * @property RefParameterSubUnsur[] $refParameterSubUnsurs
 * @property RefUnsur $kdUnsur
 * @property RefSurvaiAwal[] $refSurvaiAwals
 */
class RefSubUnsur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_sub_unsur';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_unsur', 'kd_sub_unsur'], 'required'],
            [['kd_unsur', 'kd_sub_unsur'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['kd_unsur', 'kd_sub_unsur'], 'unique', 'targetAttribute' => ['kd_unsur', 'kd_sub_unsur']],
            [['kd_unsur'], 'exist', 'skipOnError' => true, 'targetClass' => RefUnsur::className(), 'targetAttribute' => ['kd_unsur' => 'kd_unsur']],
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
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefParameterSubUnsurs()
    {
        return $this->hasMany(RefParameterSubUnsur::className(), ['kd_unsur' => 'kd_unsur', 'kd_sub_unsur' => 'kd_sub_unsur']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKdUnsur()
    {
        return $this->hasOne(RefUnsur::className(), ['kd_unsur' => 'kd_unsur']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefSurvaiAwals()
    {
        return $this->hasMany(RefSurvaiAwal::className(), ['sub_unsur_id' => 'id']);
    }
}
