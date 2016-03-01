<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "VERSION_DOCUMENTO".
 *
 * @property string $DOC_CODIGO
 * @property integer $VER_ID
 * @property string $VER_DESCRIPCION
 * @property integer $VER_NUMEROCOPIA
 * @property string $VER_FECHA_VIGENCIA_INICIO
 * @property string $VER_FECHA_VIGENCIA_TERMINO
 * @property string $VER_URL
 * @property string $VER_NUMERO_EDICION
 *
 * @property HISTORIALVERSIONDOCUMENTO[] $hISTORIALVERSIONDOCUMENTOs
 * @property HISTORIALVERSIONDOCUMENTO[] $hISTORIALVERSIONDOCUMENTOs0
 * @property SOLICITUDDOCUMENTO[] $sOLICITUDDOCUMENTOs
 * @property SOLICITUDDOCUMENTO[] $sOLICITUDDOCUMENTOs0
 * @property DOCUMENTO $dOCCODIGO
 */
class VersionDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VERSION_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DOC_CODIGO'], 'required'],
            [['VER_NUMERO_COPIA'], 'integer'],
            [['DOC_CODIGO','VER_DESCRIPCION', 'VER_URL','VER_NUMERO_EDICION'], 'string'],
            [['VER_FECHA_VIGENCIA_INICIO', 'VER_FECHA_VIGENCIA_TERMINO'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DOC_CODIGO' => 'Código Documento',
            'VER_ID' => 'Versión Documento',
            'VER_DESCRIPCION' => 'Descripcion de la Versión',
            'VER_NUMERO_COPIA' => 'Número copia',
            'VER_FECHA_VIGENCIA_INICIO' => ' Inicio  Vigencia',
            'VER_FECHA_VIGENCIA_TERMINO' => 'Término Vigencia ',
            'VER_URL' => 'URL',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHISTORIALVERSIONDOCUMENTOs()
    {
        return $this->hasMany(HISTORIALVERSIONDOCUMENTO::className(), ['VER_ID' => 'VER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHISTORIALVERSIONDOCUMENTOs0()
    {
        return $this->hasMany(HISTORIALVERSIONDOCUMENTO::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLICITUDDOCUMENTOs()
    {
        return $this->hasMany(SOLICITUDDOCUMENTO::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLICITUDDOCUMENTOs0()
    {
        return $this->hasMany(SOLICITUDDOCUMENTO::className(), ['VER_ID' => 'VER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOCCODIGO()
    {
        return $this->hasOne(DOCUMENTO::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }
}
