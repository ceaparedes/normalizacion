<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "DERIVACION_SOLICITUD_DOCUMENTO".
 *
 * @property integer $DSD_ID
 * @property integer $EDS_ID
 * @property string $SOL_ID
 * @property string $USU_RUT
 * @property string $DSD_CARGO
 * @property string $DSD_UNIDAD
 * @property string $DSD_FECHA_DERIVACION
 * @property string $DSD_FECHA_RESPUESTA
 *
 * @property ADJUNTOS[] $aDJUNTOSs
 * @property USUARIO $uSURUT
 * @property SOLICITUDDOCUMENTO $sOL
 * @property ESTADODERIVACIONSOLICITUDDOCUMENTO $eDS
 */
class DerivacionSolicitudDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DERIVACION_SOLICITUD_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EDS_ID'], 'integer'],
            [['SOL_ID', 'USU_RUT', 'DSD_CARGO', 'DSD_UNIDAD'], 'string'],
            [['DSD_FECHA_DERIVACION', 'DSD_FECHA_RESPUESTA'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DSD_ID' => 'Dsd  ID',
            'EDS_ID' => 'Eds  ID',
            'SOL_ID' => 'Sol  ID',
            'USU_RUT' => 'Usu  Rut',
            'DSD_CARGO' => 'Dsd  Cargo',
            'DSD_UNIDAD' => 'Dsd  Unidad',
            'DSD_FECHA_DERIVACION' => 'Dsd  Fecha  Derivacion',
            'DSD_FECHA_RESPUESTA' => 'Dsd  Fecha  Respuesta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getADJUNTOSs()
    {
        return $this->hasMany(ADJUNTOS::className(), ['DSD_ID' => 'DSD_ID']);
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
    public function getSOL()
    {
        return $this->hasOne(SOLICITUDDOCUMENTO::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEDS()
    {
        return $this->hasOne(ESTADODERIVACIONSOLICITUDDOCUMENTO::className(), ['EDS_ID' => 'EDS_ID']);
    }
}
