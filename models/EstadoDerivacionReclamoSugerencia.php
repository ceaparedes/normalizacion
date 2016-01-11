<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ESTADO_DERIVACION_RECLAMO_SUGERENCIA".
 *
 * @property integer $EDR_ID
 * @property string $EDR_ESTADO
 *
 * @property DERIVACIONRECLAMOSUGERENCIA[] $dERIVACIONRECLAMOSUGERENCIAs
 */
class EstadoDerivacionReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ESTADO_DERIVACION_RECLAMO_SUGERENCIA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EDR_ESTADO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EDR_ID' => 'Edr  ID',
            'EDR_ESTADO' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDERIVACIONRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(DERIVACIONRECLAMOSUGERENCIA::className(), ['EDR_ID' => 'EDR_ID']);
    }
}
