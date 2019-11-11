<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * This is the model class for table "best_practice_file".
 *
 * @property int $id
 * @property int $kd_unsur
 * @property int $kd_sub_unsur
 * @property int $level
 * @property string $name
 * @property string $uraian
 * @property string $file
 * @property string $filename
 * @property string $ref
 */
class BestPracticeFile extends \yii\db\ActiveRecord
{
    public $image;
    public $uploadPath;
    public $uploadUrl;

    public function init() {
        parent::init();
        $this->uploadPath = Yii::getAlias('@webroot'). '/uploads/spip/';
        $this->uploadUrl = Yii::$app->urlManager->baseUrl .'/uploads/spip/';
    }    

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'best_practice_file';
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
            [['name', 'file', 'filename'], 'string', 'max' => 255],
            [['ref'], 'string', 'max' => 20],
            [['image'], 'file', 'extensions' => 'xls, xlsx, csv, pdf, jpg, jpeg, png'],
            [['file', 'filename'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'uraian' => 'Uraian',
            'file' => 'File',
            'filename' => 'Filename',
            'ref' => 'Ref',
            'image' => 'File'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // ...custom code here...
        $this->name = $this->filename;
        return true;
    }


    /**
     * fetch stored image file name with complete path 
     * @return string
     */
    public function getImageFile() 
    {
        return isset($this->file) ? $this->uploadPath . $this->file : null;
    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl() 
    {
        // return a default image placeholder if your source avatar is not found
        $file = isset($this->file) ? $this->file : 'null.pdf';
        return $this->uploadUrl . $file;
    }

    public function getAbsoluteImageUrl()
    {
        $file = isset($this->file) ? $this->file : 'null.pdf';
        return Url::to('@web/uploads/spip/'.$file, true);
    }

    /**
    * Process upload of image
    *
    * @return mixed the uploaded image instance
    */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->filename = $image->name;
        $fileName = explode(".", $image->name);
        $ext = end($fileName);

        // generate a unique file name
        $this->file = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }

    /**
    * Process deletion of image
    *
    * @return boolean the status of deletion
    */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->file = null;
        $this->filename = null;

        return true;
    }    
}
