<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TIPO_ACCION_SOLICITUD".
 *
 * @property integer $ODO_ID
 * @property integer $TAS_ID
 * @property string $TAS_ACCION
 *
 * @property SOLICITUDDOCUMENTO[] $sOLICITUDDOCUMENTOs
 * @property SOLICITUDDOCUMENTO[] $sOLICITUDDOCUMENTOs0
 * @property ORIGENDOCUMENTO $oDO
 */
class TipoAccionSolicitud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TIPO_ACCION_SOLICITUD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ODO_ID'], 'required'],
            [['ODO_ID'], 'integer'],
            [['TAS_ACCION'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ODO_ID' => 'Odo  ID',
            'TAS_ID' => 'Tas  ID',
            'TAS_ACCION' => 'Tas  Accion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLICITUDDOCUMENTOs()
    {
        return $this->hasMany(SOLICITUDDOCUMENTO::className(), ['ODO_ID' => 'ODO_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLICITUDDOCUMENTOs0()
    {
        return $this->hasMany(SOLICITUDDOCUMENTO::className(), ['TAS_ID' => 'TAS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODO()
    {
        return $this->hasOne(ORIGENDOCUMENTO::className(), ['ODO_ID' => 'ODO_ID']);
    }
}
