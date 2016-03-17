<?php

namespace app\models;
use Yii;


class docs extends \yii\db\ActiveRecord
{
public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->dbdocs;
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
            'id' => 'Documentos',
            'idc' => 'Categoría id',
            'tipo' => 'tipo Documento',//reglamentos, policticas, etc
            'tipod' => 'Categoría Documento',
            'especie' => 'Origen Documento',
            'activo' => 'activo',
            'titulo' => 'Documento',
            'resumen' => 'resumen',
            'archivo' => 'URL',

        ];
    }

}
?>
