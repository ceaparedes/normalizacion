<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "SOLICITUD_DOCUMENTO".
 *
 * @property string $SOL_ID
 * @property integer $DOC_CODIGO
 * @property integer $VER_ID
 * @property integer $PDA_ID
 * @property integer $ESO_ID
 * @property string $USU_RUT
 * @property integer $ODO_ID
 * @property integer $TAS_ID
 * @property integer $SIS_ID
 * @property integer $SRS_ID
 * @property string $SOL_FECHA
 * @property string $SOL_UNIDAD
 * @property string $SOL_FUNDAMENTO
 *
 * @property ADJUNTOS[] $aDJUNTOSs
 * @property BORRADORDOCUMENTO[] $bORRADORDOCUMENTOs
 * @property DERIVACIONSOLICITUDDOCUMENTO[] $dERIVACIONSOLICITUDDOCUMENTOs
 * @property DETALLECAMBIOSSOLICITUD[] $dETALLECAMBIOSSOLICITUDs
 * @property HISTORIALSOLICITUD[] $hISTORIALSOLICITUDs
 * @property VERSIONDOCUMENTO $dOCCODIGO
 * @property VERSIONDOCUMENTO $vER
 * @property SOLUCIONRECLAMOSUGERENCIA $sRS
 * @property USUARIO $uSURUT
 * @property SOLUCIONINMEDIATASACSAP $sIS
 * @property TIPOACCIONSOLICITUD $oDO
 * @property PLANDEACCION $pDA
 * @property TIPOACCIONSOLICITUD $tAS
 * @property ESTADOSOLICITUD $eSO
 * @property SOLUCIONINMEDIATASACSAP[] $sOLUCIONINMEDIATASACSAPs
 */
class SolicitudDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SOLICITUD_DOCUMENTO';
    }

    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SOL_ID'], 'required'],
            [['SOL_ID', 'USU_RUT', 'SOL_UNIDAD', 'SOL_FUNDAMENTO'], 'string'],
            [['file'],'file'],

            [['SOL_FECHA','DOC_CODIGO', 'VER_ID', 'PDA_ID', 'ESO_ID', 'ODO_ID', 'TAS_ID', 'SIS_ID', 'SRS_ID'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SOL_ID' => 'Nº Solicitud',
            'DOC_CODIGO' => 'Codigo Documento',
            'VER_ID' => 'ID Version',
            'PDA_ID' => 'ID Plan de Accion',
            'ESO_ID' => 'Estado',
            'USU_RUT' => 'Usuario',
            'ODO_ID' => 'Origen',
            'TAS_ID' => 'Tipo Accion',
            'SIS_ID' => 'ID Solucion SAC-SAP',
            'SRS_ID' => 'ID Solucion Reclamo Sugerencia',
            'SOL_FECHA' => 'Fecha Solicitud',
            'SOL_UNIDAD' => 'Unidad',
            'SOL_FUNDAMENTO' => 'Fundamento',
            'file'=>'Adjunto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getADJUNTOSs()
    {
        return $this->hasMany(ADJUNTOS::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBORRADORDOCUMENTOs()
    {
        return $this->hasMany(BORRADORDOCUMENTO::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDERIVACIONSOLICITUDDOCUMENTOs()
    {
        return $this->hasMany(DERIVACIONSOLICITUDDOCUMENTO::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDETALLECAMBIOSSOLICITUDs()
    {
        return $this->hasMany(DETALLECAMBIOSSOLICITUD::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHISTORIALSOLICITUDs()
    {
        return $this->hasMany(HISTORIALSOLICITUD::className(), ['SOL_ID' => 'SOL_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOCCODIGO()
    {
        return $this->hasOne(VERSIONDOCUMENTO::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVER()
    {
        return $this->hasOne(VERSIONDOCUMENTO::className(), ['VER_ID' => 'VER_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSRS()
    {
        return $this->hasOne(SOLUCIONRECLAMOSUGERENCIA::className(), ['SRS_ID' => 'SRS_ID']);
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
    public function getSIS()
    {
        return $this->hasOne(SOLUCIONINMEDIATASACSAP::className(), ['SIS_ID' => 'SIS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getODO()
    {
        return $this->hasOne(TIPOACCIONSOLICITUD::className(), ['ODO_ID' => 'ODO_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPDA()
    {
        return $this->hasOne(PLANDEACCION::className(), ['PDA_ID' => 'PDA_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTAS()
    {
        return $this->hasOne(TIPOACCIONSOLICITUD::className(), ['TAS_ID' => 'TAS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getESO()
    {
        return $this->hasOne(ESTADOSOLICITUD::className(), ['ESO_ID' => 'ESO_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLUCIONINMEDIATASACSAPs()
    {
        return $this->hasMany(SOLUCIONINMEDIATASACSAP::className(), ['SOL_ID' => 'SOL_ID']);
    }
}
