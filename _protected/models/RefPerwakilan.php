<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ref_perwakilan".
 *
 * @property string $id
 * @property string $name
 *
 * @property Lapbul[] $lapbuls
 */
class RefPerwakilan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_perwakilan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLapbuls()
    {
        return $this->hasMany(Lapbul::className(), ['perwakilan_id' => 'id']);
    }
}
