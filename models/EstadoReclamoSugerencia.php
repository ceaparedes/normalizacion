<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ESTADO_RECLAMO_SUGERENCIA".
 *
 * @property integer $ERS_ID
 * @property string $ERS_ESTADO
 *
 * @property HISTORIALESTADOS[] $hISTORIALESTADOSs
 * @property RECLAMOSUGERENCIA[] $rECLAMOSUGERENCIAs
 */
class EstadoReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ESTADO_RECLAMO_SUGERENCIA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ERS_ESTADO'], 'string'],
            [['ERS_ID'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ERS_ID' => 'Ers  ID',
            'ERS_ESTADO' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHISTORIALESTADOSs()
    {
        return $this->hasMany(HISTORIALESTADOS::className(), ['ERS_ID' => 'ERS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(RECLAMOSUGERENCIA::className(), ['ERS_ID' => 'ERS_ID']);
    }
}
