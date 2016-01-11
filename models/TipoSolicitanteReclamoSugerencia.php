<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TIPO_SOLICITANTE_RECLAMO_SUGERENCIA".
 *
 * @property integer $TSR_ID
 * @property string $TSR_TIPO_SOLICITANTE
 *
 * @property RECLAMOSUGERENCIA[] $rECLAMOSUGERENCIAs
 */
class TipoSolicitanteReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TIPO_SOLICITANTE_RECLAMO_SUGERENCIA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TSR_TIPO_SOLICITANTE'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TSR_ID' => 'Tsr  ID',
            'TSR_TIPO_SOLICITANTE' => 'Tipo  Solicitante',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(RECLAMOSUGERENCIA::className(), ['TSR_ID' => 'TSR_ID']);
    }
}
