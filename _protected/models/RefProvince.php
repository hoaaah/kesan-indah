<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_province".
 *
 * @property integer $id
 * @property string $perwakilan_id
 * @property string $name
 * @property string $pendek
 */
class RefProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['perwakilan_id', 'name', 'pendek'], 'required'],
            [['perwakilan_id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
            [['pendek'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'perwakilan_id' => 'Perwakilan ID',
            'name' => 'Name',
            'pendek' => 'Pendek',
        ];
    }
}
