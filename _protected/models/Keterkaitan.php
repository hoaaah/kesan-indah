<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "keterkaitan".
 *
 * @property int $id
 * @property int $kd_unsur
 * @property int $kd_sub_unsur
 * @property int $level
 * @property int $kategori
 * @property int $kd_unsur_lwn
 * @property int $kd_sub_unsur_lwn
 * @property int $level_lwn
 * @property string $uraian
 */
class Keterkaitan extends \yii\db\ActiveRecord
{

    public $kd_gabungan_lwn;
    public $checkIfKeterkaitanSaved;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'keterkaitan';
    }

    public function kategoriKeterkaitanList()
    {
        return [
            1 => "Keterkaitan Dokumen yang sama",
            2 => "Keterkaitan Berlaku Jika Sub Unsur lain terpenuhi",
            3 => "Keterkaitan Berlaku Untuk membuka unsur lain"
        ];
    }

    
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        if($this->kd_gabungan_lwn) list($this->kd_unsur_lwn, $this->kd_sub_unsur_lwn) = explode(".", $this->kd_gabungan_lwn);
        if(!$this->checkIfKeterkaitanSaved) $this->checkIfKeterkaitanSaved = 1;

        
        $keterkaitan = Keterkaitan::findOne([
            'kd_unsur' => $this->kd_unsur,
            'kd_sub_unsur' => $this->kd_sub_unsur,
            'level' => $this->level,
            'kategori' => $this->kategori,
            'kd_unsur_lwn' => $this->kd_unsur_lwn,
            'kd_sub_unsur_lwn' => $this->kd_sub_unsur_lwn,
            'level_lwn' => $this->level_lwn,
        ]);
        if($keterkaitan){
            $this->addError('kd_gabungan_lwn', "Sudah ada data atas keterkaitan ini");
            return false;
        } 
        
        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if(!$insert)
        {
            $oldAttributes = $this->oldAttributes;
            Keterkaitan::findOne([
                'kd_unsur' => $oldAttributes->kd_unsur_lwn,
                'kd_sub_unsur' => $oldAttributes->kd_sub_unsur_lwn,
                'level' => $oldAttributes->level_lwn,
                'kd_unsur_lwn' => $oldAttributes->kd_unsur,
                'kd_sub_unsur_lwn' => $oldAttributes->kd_sub_unsur,
                'level_lwn' => $oldAttributes->level,
                'kategori' => $oldAttributes->kategori == 1 ? $oldAttributes->kategori : 3,
            ])->delete();
        }

        if($this->checkIfKeterkaitanSaved == 1){
            $keterkaitanLwn = new Keterkaitan();
            $keterkaitanLwn->kategori = $this->kategori;
            if($this->kategori == 2) $keterkaitanLwn->kategori = 3;
            $keterkaitanLwn->kd_unsur = $this->kd_unsur_lwn;
            $keterkaitanLwn->kd_sub_unsur = $this->kd_sub_unsur_lwn;
            $keterkaitanLwn->level = $this->level_lwn;
            $keterkaitanLwn->kd_unsur_lwn = $this->kd_unsur;
            $keterkaitanLwn->kd_sub_unsur_lwn = $this->kd_sub_unsur;
            $keterkaitanLwn->level_lwn = $this->level;
            $keterkaitanLwn->uraian = $this->uraian;
            $keterkaitanLwn->checkIfKeterkaitanSaved = 2;
            $keterkaitanLwn->save();
        }
    }

    public function afterDelete()
    {
        if(in_array($this->kategori, [1, 2])){
            Keterkaitan::findOne([
                'kd_unsur' => $this->kd_unsur_lwn,
                'kd_sub_unsur' => $this->kd_sub_unsur_lwn,
                'level' => $this->level_lwn,
                'kd_unsur_lwn' => $this->kd_unsur,
                'kd_sub_unsur_lwn' => $this->kd_sub_unsur,
                'level_lwn' => $this->level,
                'kategori' => $this->kategori == 1 ? $this->kategori : 3,
            ])->delete();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_unsur', 'kd_sub_unsur', 'level', 'kategori'], 'required'],
            [['kd_unsur', 'kd_sub_unsur', 'level', 'kategori', 'kd_unsur_lwn', 'kd_sub_unsur_lwn', 'level_lwn'], 'integer'],
            [['uraian', 'kd_gabungan_lwn'], 'string'],
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
            'kategori' => 'Kategori',
            'kd_unsur_lwn' => 'Kd Unsur Lwn',
            'kd_sub_unsur_lwn' => 'Kd Sub Unsur Lwn',
            'level_lwn' => 'Level Lwn',
            'uraian' => 'Uraian',
        ];
    }
}
