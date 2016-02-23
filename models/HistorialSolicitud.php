<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "HISTORIAL_SOLICITUD".
 *
 * @property integer $HSO_ID
 * @property integer $ESO_ID
 * @property string $USU_RUT
 * @property string $SOL_ID
 * @property string $HSO_FECHA_HORA
 * @property string $HSO_COMENTARIO
 *
 * @property SOLICITUDDOCUMENTO $sOL
 * @property USUARIO $uSURUT
 * @property ESTADOSOLICITUD $eSO
 */
class HistorialSolicitud extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'HISTORIAL_SOLICITUD';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ESO_ID'], 'integer'],
            [['USU_RUT', 'SOL_ID', 'HSO_COMENTARIO'], 'string'],
            [['HSO_FECHA_HORA'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HSO_ID' => 'ID',
            'ESO_ID' => 'Estado',
            'USU_RUT' => 'Usuario',
            'SOL_ID' => 'Solicitud Nº',
            'HSO_FECHA_HORA' => 'Fecha',
            'HSO_COMENTARIO' => 'Comentario',
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
    public function getUSURUT()
    {
        return $this->hasOne(USUARIO::className(), ['USU_RUT' => 'USU_RUT']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getESO()
    {
        return $this->hasOne(ESTADOSOLICITUD::className(), ['ESO_ID' => 'ESO_ID']);
    }
}
