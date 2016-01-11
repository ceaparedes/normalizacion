<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ESTADO_SOLUCION_RECLAMO_SUGERENCIA".
 *
 * @property integer $ESR_ID
 * @property string $ESR_ESTADO
 *
 * @property SOLUCIONRECLAMOSUGERENCIA[] $sOLUCIONRECLAMOSUGERENCIAs
 */
class EstadoSolucionReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ESTADO_SOLUCION_RECLAMO_SUGERENCIA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ESR_ESTADO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ESR_ID' => 'Esr  ID',
            'ESR_ESTADO' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLUCIONRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(SOLUCIONRECLAMOSUGERENCIA::className(), ['ESR_ID' => 'ESR_ID']);
    }
}
