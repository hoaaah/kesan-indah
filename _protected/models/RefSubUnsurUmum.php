<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_sub_unsur_umum".
 *
 * @property int $id
 * @property int $kd_unsur
 * @property int $kd_sub_unsur
 * @property int $level
 * @property string $uraian
 */
class RefSubUnsurUmum extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_sub_unsur_umum';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_unsur', 'kd_sub_unsur', 'level'], 'required'],
            [['kd_unsur', 'kd_sub_unsur', 'level'], 'integer'],
            [['uraian'], 'string'],
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
            'uraian' => 'Uraian',
        ];
    }
}
