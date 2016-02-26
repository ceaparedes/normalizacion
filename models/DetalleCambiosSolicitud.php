<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DETALLE_CAMBIOS_SOLICITUD".
 *
 * @property integer $DCS_ID
 * @property string $SOL_ID
 * @property string $DCS_CAMBIOS
 *
 * @property SOLICITUDDOCUMENTO $sOL
 */
class DetalleCambiosSolicitud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DETALLE_CAMBIOS_SOLICITUD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SOL_ID'], 'required'],
            [['SOL_ID', 'DCS_CAMBIOS'], 'string'],
            [['DCS_CAMBIOS'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DCS_ID' => 'Dcs  ID',
            'SOL_ID' => 'Sol  ID',
            'DCS_CAMBIOS' => 'Cambios Propuestos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOL()
    {
        return $this->hasOne(SOLICITUDDOCUMENTO::className(), ['SOL_ID' => 'SOL_ID']);
    }
}
