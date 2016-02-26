<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DOCUMENTO".
 *
 * @property integer $DOC_CODIGO
 * @property integer $ODO_ID
 * @property integer $UOD_ID
 * @property string $DOC_TITULO
 * @property string $DOC_TIPO
 *
 * @property DETALLEAUDITORIA[] $dETALLEAUDITORIAs
 * @property ORIGENDOCUMENTO $oDO
 * @property UNIDADORIGENDOCUMENTO $uOD
 * @property VERSIONDOCUMENTO[] $vERSIONDOCUMENTOs
 */
class Documento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['DOC_CODIGO', 'ODO_ID', 'UOD_ID'], 'required'],
            [['DOC_CODIGO', 'ODO_ID', 'UOD_ID'], 'integer'],
            [['DOC_TITULO', 'DOC_TIPO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DOC_CODIGO' => 'Codigo Documento',
            'ODO_ID' => 'Odo  ID',
            'UOD_ID' => 'Uod  ID',
            'DOC_TITULO' => 'Titulo',
            'DOC_TIPO' => 'Doc  Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDETALLEAUDITORIAs()
    {
        return $this->hasMany(DETALLEAUDITORIA::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODO()
    {
        return $this->hasOne(ORIGENDOCUMENTO::className(), ['ODO_ID' => 'ODO_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUOD()
    {
        return $this->hasOne(UNIDADORIGENDOCUMENTO::className(), ['UOD_ID' => 'UOD_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVERSIONDOCUMENTOs()
    {
        return $this->hasMany(VERSIONDOCUMENTO::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }
}
