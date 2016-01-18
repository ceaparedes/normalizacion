<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "BORRADOR_DOCUMENTO".
 *
 * @property integer $BDO_ID
 * @property integer $EBD_ID
 * @property string $SOL_ID
 * @property string $BDO_FECHA_ENVIO
 * @property string $BDO_FECHA_RESPUESTA
 *
 * @property SOLICITUDDOCUMENTO $sOL
 * @property ESTADOBORRADORDOCUMENTO $eBD
 */
class BorradorDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'BORRADOR_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EBD_ID'], 'required'],
            [['EBD_ID'], 'integer'],
            [['SOL_ID'], 'string'],
            [['BDO_FECHA_ENVIO', 'BDO_FECHA_RESPUESTA'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BDO_ID' => 'Bdo  ID',
            'EBD_ID' => 'Ebd  ID',
            'SOL_ID' => 'Sol  ID',
            'BDO_FECHA_ENVIO' => 'Bdo  Fecha  Envio',
            'BDO_FECHA_RESPUESTA' => 'Bdo  Fecha  Respuesta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOL()
    {
        return $this->hasOne(SOLICITUDDOCUMENTO::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEBD()
    {
        return $this->hasOne(ESTADOBORRADORDOCUMENTO::className(), ['EBD_ID' => 'EBD_ID']);
    }
}
