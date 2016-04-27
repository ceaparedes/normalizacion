<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;


class Personal extends \yii\db\ActiveRecord
{
  public static function getDb()
      {
          // use the "db2" application component
          return \Yii::$app->dbcreditotest;
      }

  public static function tableName()
  {
      return 'VTA_www_PERSONAL';
  }

  public function rules()
  {
    return [

        [['mae_rut','mae_nombre', 'mae_apellido_paterno'], 'safe'],

    ];
  }

  public function attributeLabels()
  {
      return [
          'mae_nombre'=>'Nombre',
          'mae_apellido_paterno'=> 'Apellido',
      ];
  }
}
