<?php

namespace app\models;

use Yii;
//use models
use app\models\TipoReclamoSugerencia;
use app\models\TipoSolicitanteReclamoSugerencia;
use app\models\EstadoReclamoSugerencia;
use app\models\Adjuntos;

/**
 * This is the model class for table "RECLAMO_SUGERENCIA".

 * @property string $REC_NOMBRE_USUARIO
 * @property string $REC_EMAIL_USUARIO
 * @property integer $REC_TELEFONO_USUARIO
 * @property string $REC_NUMERO
 * @property string $USU_RUT
 * @property integer $ERS_ID
 * @property integer $TSR_ID
 * @property integer $TRS_ID
 * @property string $REC_FECHA
 * @property string $REC_REPARTICION
 * @property string $REC_HORA
 * @property string $REC_MOTIVO
 * @property string $REC_VISTO_BUENO
 * //Relaciones (joins)
 * @property ADJUNTOS[] $aDJUNTOSs
 * @property HISTORIALESTADOS[] $hISTORIALESTADOSs
 * @property ESTADORECLAMOSUGERENCIA $eRS
 * @property TIPOSOLICITANTERECLAMOSUGERENCIA $tSR
 * @property TIPORECLAMOSUGERENCIA $tRS
 * @property USUARIO $uSURUT
 * @property SOLUCIONRECLAMOSUGERENCIA[] $sOLUCIONRECLAMOSUGERENCIAs
 */
class ReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'RECLAMO_SUGERENCIA';
    }

    //atributo necesario para realizar un adjunto
    public $file;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['REC_NUMERO', 'TSR_ID', 'TRS_ID', 'REC_MOTIVO'], 'required'],
            [['REC_NUMERO', 'USU_RUT', 'REC_REPARTICION', 'REC_VISTO_BUENO', 'REC_NOMBRE_USUARIO'], 'string'],
            [['REC_REPARTICION'],'string', 'max'=>100],
            [['REC_MOTIVO'],'string', 'max'=>250],
            [['REC_EMAIL_USUARIO'],'email'],
            [['file'],'file', 'skipOnEmpty' => true, 'maxSize' => 1024 * 1024 * 2],
            [['ERS_ID', 'TSR_ID', 'TRS_ID','REC_TELEFONO_USUARIO'], 'integer'],
            [['REC_FECHA', 'REC_HORA', 'ERS_ID'], 'safe'],
            [['REC_MOTIVO','REC_REPARTICION'], 'textValidate'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'REC_NUMERO' => 'Número ',
            'USU_RUT' => 'Rut Usuario',
            'ERS_ID' => 'Estado',
            'REC_NOMBRE_USUARIO' => 'Nombre Usuario',
            'REC_EMAIL_USUARIO' => 'Correo Electrónico',
            'REC_TELEFONO_USUARIO' => 'Teléfono/celular',
            'TSR_ID' => 'Tipo Solicitante',
            'TRS_ID' => 'Tipo Solicitud',
            'REC_FECHA' => 'Fecha',
            'REC_REPARTICION' => 'Unidad',
            'REC_HORA' => 'Hora',
            'REC_MOTIVO' => 'Motivo',
            'REC_VISTO_BUENO' => 'Visto  Bueno',
            'file'=> 'Archivo adjunto'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHISTORIALESTADOSs()
    {
        return $this->hasMany(HISTORIALESTADOS::className(), ['REC_NUMERO' => 'REC_NUMERO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getERS()
    {
        return $this->hasOne(ESTADORECLAMOSUGERENCIA::className(), ['ERS_ID' => 'ERS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTSR()
    {
        return $this->hasOne(TIPOSOLICITANTERECLAMOSUGERENCIA::className(), ['TSR_ID' => 'TSR_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTRS()
    {
        return $this->hasOne(TIPORECLAMOSUGERENCIA::className(), ['TRS_ID' => 'TRS_ID']);
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
    public function getSOLUCIONRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(SOLUCIONRECLAMOSUGERENCIA::className(), ['REC_NUMERO' => 'REC_NUMERO']);
    }

    public function getADJUNTOSs()
    {
        return $this->hasMany(ADJUNTOS::className(), ['DRS_ID' => 'DRS_ID']);
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
