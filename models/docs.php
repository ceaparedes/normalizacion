<?php

namespace app\models;
use Yii;


class docs extends \yii\db\ActiveRecord
{
public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->db2;
    }

    public static function tableName()
    {
        return 'docs';
    }

    public function rules()
    {
        return [
            [['id','idc','tipo','tipod','especie','activo'], 'integer'],
            [['titulo', 'archivo', ], 'string' ,'max'=>2048],
            [['resumen'],'string'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'idc' => 'idc',
            'tipo' => 'tipo',
            'tipod' => 'tipod',
            'especie' => 'especie',
            'activo' => 'activo',
            'titulo' => 'Documento',
            'resumen' => 'resumen',
            'archivo' => 'URL',

        ];
    }

}
?>
