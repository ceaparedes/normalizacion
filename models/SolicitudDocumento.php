<?php

namespace app\models;

use Yii;
use app\models\OrigenDocumento;

/**
 * This is the model class for table "SOLICITUD_DOCUMENTO".
 *
 * @property string $SOL_ID
 * @property string $DOC_CODIGO
 * @property integer $VER_ID
 * @property integer $PDA_ID
 * @property integer $ESO_ID
 * @property string $USU_RUT
 * @property integer $ODO_ID
 * @property integer $TAS_ID
 * @property integer $SIS_ID
 * @property integer $SRS_ID
 * @property string $SOL_FECHA
 * @property string $SOL_HORA
 * @property string $SOL_UNIDAD
 * @property string $SOL_FUNDAMENTO
 * @property string $SOL_VISTO_BUENO
 *
 * @property ADJUNTOS[] $aDJUNTOSs
 * @property BORRADORDOCUMENTO[] $bORRADORDOCUMENTOs
 * @property DERIVACIONSOLICITUDDOCUMENTO[] $dERIVACIONSOLICITUDDOCUMENTOs
 * @property DETALLECAMBIOSSOLICITUD[] $dETALLECAMBIOSSOLICITUDs
 * @property HISTORIALSOLICITUD[] $hISTORIALSOLICITUDs
 * @property DOCUMENTO $dOCCODIGO
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
            [['SOL_ID', 'SOL_FUNDAMENTO'], 'required'],
            [['SOL_ID', 'USU_RUT', 'SOL_UNIDAD', 'SOL_FUNDAMENTO'], 'string'],
            [['file'],'file','skipOnEmpty' => true,  'extensions'=> 'jpg, png, doc, docx, pdf'],

            [['SOL_FECHA','DOC_CODIGO', 'VER_ID', 'PDA_ID', 'ESO_ID', 'ODO_ID', 'TAS_ID', 'SIS_ID', 'SRS_ID','SOL_VISTO_BUENO','SOL_HORA'], 'safe'],
            [['SOL_FUNDAMENTO'], 'textValidate']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SOL_ID' => 'Nº Solicitud',
            'DOC_CODIGO' => 'Documento',
            'VER_ID' => 'Version Documento',
            'PDA_ID' => 'ID Plan de Accion',
            'ESO_ID' => 'Estado',
            'USU_RUT' => 'Usuario',
            'ODO_ID' => 'Origen',
            'TAS_ID' => 'Tipo Accion',
            'SIS_ID' => 'ID Solucion SAC-SAP',
            'SRS_ID' => 'ID Solucion Reclamo Sugerencia',
            'SOL_FECHA' => 'Fecha Solicitud',
            'SOL_HORA' => 'Hora Solicitud',
            'SOL_UNIDAD' => 'Unidad',
            'SOL_FUNDAMENTO' => 'Fundamento',
            'SOL_VISTO_BUENO' =>'Visto Bueno',
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
        return $this->hasOne(OrigenDocumento::className(), ['ODO_ID' => 'ODO_ID']);
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


    public function textValidate($attribute,$params)
      {
          $pattern2 ='/(aaa|eee|iii|ooo|uuu|bbb|ccc|ddd|fff|ggg|hhh|jjj|kkk|llll|mmm|nnn|ñññ|ppp|qqq|rrr|sss|ttt|vvv|www|xxx|yyy|zzz|ºº|°°|!!|\.\.|\'\'|\"\"|\,\,)/i';
          $pattern3 ='/(AAA|EEE|III|OOO|UUU|BBB|CCC|DDD|FFF|GGG|HHH|JJJ|KKK|LLLL|MMM|NNN|ÑÑÑ|PPP|QQQ|RRR|SSS|TTT|VVV|WWW|XXX|YYY|ZZZ)/i';
          $pattern4 ='/(ááá|ÁÁA|ééá|ÉÉÉ|ííí|ÍÍÍ|óóó|ÓÓÓ|úúú|ÚÚÚ)/i';
          $pattern5 = '/(1111|2222|3333|4444|5555|6666|7777|8888|9999|0000)/i';
          $pattern6 = '/(conchetumare|mierda|weon|puto|puta|culiao|hueon|CONCHETUMARE|MIERDA|WEON|PUTO|PUTA|CULIAO|HUEON|maraca|MARACA|maricon|MARICON|chupalo|CHUPALO)/i';

          $pattern7 ='/^([a-zA-ZñÑáéíóú0-9º°\.\,\'\"\)\(\-\@\:\/\+]+([[:space:][:punct:]]{0,2}[a-zA-ZñÑáéíóú0-9º°\.\,\'\"\)\(\-\@\:\/\+?!]+)*)$/D';  //fixed

          $pattern8 ='/^([0-9º°\.\,\'\"\)\(\-\@\:\/\+]+)$/i';

        if(!preg_match($pattern7, $this->$attribute))$this->addError($attribute,'Verifique que su texto tenga al menos una palabra.');

        if(preg_match($pattern8, $this->$attribute) )$this->addError($attribute,'Debe ingresar una palabra');

        if(preg_match($pattern2, $this->$attribute) OR preg_match($pattern3, $this->$attribute) OR preg_match($pattern4, $this->$attribute) OR preg_match($pattern5, $this->$attribute) OR preg_match($pattern6, $this->$attribute))
        $this->addError($attribute,'Verifique el texto ingresado');

      }

}
