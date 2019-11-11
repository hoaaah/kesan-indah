<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/* (C) Copyright 2017 Heru Arief Wijaya (http://belajararief.com/) untuk DJPK Kemenkeu.*/

class RefPemda extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ref_pemda';
    }

    public $image;

    public function rules()
    {
        return [
            [['id', 'province_id', 'name'], 'required'],
            [['id'], 'string', 'max' => 5],
            [['province_id'], 'integer'],
            [['perwakilan_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['image_name', 'saved_image'], 'string', 'max' => 50],
            [['ibukota'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_id' => 'Province ID',
            'name' => 'Name',
            'ibukota' => 'Ibukota',
            'image_name' => 'Image Name',
            'saved_image' => 'Saved Image',
            'image' => 'Photo',
        ];
    }


    private function checkFolder($directoryName){
        if(!is_dir($directoryName)){
            //Directory does not exist, so lets create it.
            mkdir($directoryName, 0755, true);
        }
    }

    private function checkFile($filePath){
        return file_exists($filePath);
    }

    public function getImage(){
        // // check folder first
        // $this->checkFolder('@webroot/uploads');
        // $this->checkFolder('@webroot/uploads/'.$this->pemda_id.'/kada');
        // // getImage
        // if(isset($this->image_name)){
        //     $filePath = '@webroot/uploads/'.$this->pemda_id.'/kada/'.$this->saved_image;
        //     // check file exist first
        //     // if($this->checkFile($filePath)) 
        //     return $filePath;
        // }
        // return null;

        // check folder first
        $this->checkFolder(Url::to('@webroot/uploads'));
        $this->checkFolder(Url::to('@webroot/uploads/'.$this->id.''));
        // getImage
        if(isset($this->image_name)){
            $filePath = Url::to('@webroot/uploads/'.$this->id.'/'.$this->saved_image);
            // check file exist first
            // if($this->checkFile($filePath)) 
            return $filePath;
        }
        return null;        
    }

    public function getImageUrl(){
        return Url::to('@web/uploads/'.$this->id.'/'.$this['saved_image']);
    }

    public function uploadImage(){
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no image was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        $this->image_name = $image->name;
        $imageName = (explode(".", $image->name));
        $ext = end($imageName);

        // generate a unique file name
        $this->saved_image = Yii::$app->security->generateRandomString().".{$ext}";

        // the uploaded image instance
        return $image;
    }

    public function deleteImage() {
        $file = $this->getImage();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        if (!unlink($file)) {
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->image_name = null;
        $this->saved_image = null;

        $this->save();

        return true;
    }    
}
