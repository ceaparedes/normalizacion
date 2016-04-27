<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "TIPO_RECLAMO_SUGERENCIA".
 *
 * @property integer $TRS_ID
 * @property string $TRS_TIPO
 *
 * @property RECLAMOSUGERENCIA[] $rECLAMOSUGERENCIAs
 */
class TipoReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TIPO_RECLAMO_SUGERENCIA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TRS_TIPO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'TRS_ID' => 'Trs  ID',
            'TRS_TIPO' => 'Tipo Solicitud',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(RECLAMOSUGERENCIA::className(), ['TRS_ID' => 'TRS_ID']);
    }
}
