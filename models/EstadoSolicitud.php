<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ESTADO_SOLICITUD".
 *
 * @property integer $ESO_ID
 * @property string $ESO_ESTADO
 *
 * @property HISTORIALSOLICITUD[] $hISTORIALSOLICITUDs
 * @property SOLICITUDDOCUMENTO[] $sOLICITUDDOCUMENTOs
 */
class EstadoSolicitud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ESTADO_SOLICITUD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ESO_ESTADO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ESO_ID' => 'Eso  ID',
            'ESO_ESTADO' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHISTORIALSOLICITUDs()
    {
        return $this->hasMany(HISTORIALSOLICITUD::className(), ['ESO_ID' => 'ESO_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLICITUDDOCUMENTOs()
    {
        return $this->hasMany(SOLICITUDDOCUMENTO::className(), ['ESO_ID' => 'ESO_ID']);
    }
}
