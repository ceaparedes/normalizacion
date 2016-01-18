<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ORIGEN_DOCUMENTO".
 *
 * @property integer $ODO_ID
 * @property string $ODO_ORIGEN
 *
 * @property DOCUMENTO[] $dOCUMENTOs
 * @property TIPOACCIONSOLICITUD[] $tIPOACCIONSOLICITUDs
 */
class OrigenDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ORIGEN_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ODO_ORIGEN'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ODO_ID' => 'Odo  ID',
            'ODO_ORIGEN' => 'Odo  Origen',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOCUMENTOs()
    {
        return $this->hasMany(DOCUMENTO::className(), ['ODO_ID' => 'ODO_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTIPOACCIONSOLICITUDs()
    {
        return $this->hasMany(TIPOACCIONSOLICITUD::className(), ['ODO_ID' => 'ODO_ID']);
    }
}
