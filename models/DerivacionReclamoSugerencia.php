<?php

namespace app\models;

use Yii;
use app\models\EstadoDerivacionReclamoSugerencia;
use app\models\SolucionReclamoSugerencia;

/**
 * This is the model class for table "DERIVACION_RECLAMO_SUGERENCIA".
 *
 * @property integer $DRS_ID
 * @property integer $EDR_ID
 * @property string $USU_RUT
 * @property integer $SRS_ID
 * @property string $DRS_CARGO
 * @property string $DRS_UNIDAD
 * @property string $DRS_FECHA_DERIVACION
 * @property string $DRS_FECHA_RESPUESTA
 * @property string $DRS_RESPUESTA
 * @property string $DRS_SERVICIO_NO_CONFORME
 * Relaciones (joins)
 * @property ADJUNTOS[] $aDJUNTOSs
 * @property ESTADODERIVACIONRECLAMOSUGERENCIA $eDR
 * @property SOLUCIONRECLAMOSUGERENCIA $sRS
 * @property USUARIO $uSURUT
 */
class DerivacionReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DERIVACION_RECLAMO_SUGERENCIA';
    }
    public $nombre;
    public $apellido;
    public $files;
    public $hidden;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['USU_RUT', 'DRS_CARGO', 'DRS_UNIDAD', 'DRS_RESPUESTA', 'DRS_NOMBRE' ,'nombre','apellido'], 'string'],
            [['files'],'file', 'skipOnEmpty' => true, 'maxFiles' => 6, 'extensions'=> 'doc, docx, pdf'],

            [['DRS_FECHA_DERIVACION', 'DRS_FECHA_RESPUESTA','SRS_ID', 'EDR_ID', 'hidden'], 'safe'],
            [['DRS_RESPUESTA'],'textValidate']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'DRS_ID' => 'Derivación Nº.',
            'EDR_ID' => 'Estado Derivación',
            'USU_RUT' => 'Rut',
            'SRS_ID' => 'Número Reclamo',
            'DRS_CARGO' => 'Cargo RORS',
            'DRS_UNIDAD' => 'Unidad RORS',
            'DRS_FECHA_DERIVACION' => 'Fecha  Derivacion',
            'DRS_FECHA_RESPUESTA' => 'Fecha  Respuesta',
            'DRS_NOMBRE' => 'Nombre RORS',
            'DRS_RESPUESTA' => 'Respuesta',
            'nombre'=>'Nombre',
            'apellido'=> 'Apellido',
            'files' => 'Archivo(s) Adjunto(s)',


        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getADJUNTOSs()
    {
        return $this->hasMany(ADJUNTOS::className(), ['DRS_ID' => 'DRS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEDR()
    {
        return $this->hasOne(ESTADODERIVACIONRECLAMOSUGERENCIA::className(), ['EDR_ID' => 'EDR_ID']);
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

    public function textValidate($attribute,$params)
      {
          $pattern2 ='/(aaa|eee|iii|ooo|uuu|bbb|ccc|ddd|fff|ggg|hhh|jjj|kkk|llll|mmm|nnn|ñññ|ppp|qqq|rrr|sss|ttt|vvv|www|xxx|yyy|zzz|ºº|°°|!!|\.\.|\'\'|\"\"|\,\,)/i';
          $pattern3 ='/(AAA|EEE|III|OOO|UUU|BBB|CCC|DDD|FFF|GGG|HHH|JJJ|KKK|LLLL|MMM|NNN|ÑÑÑ|PPP|QQQ|RRR|SSS|TTT|VVV|WWW|XXX|YYY|ZZZ)/i';
          $pattern4 ='/(ááá|ÁÁA|ééá|ÉÉÉ|ííí|ÍÍÍ|óóó|ÓÓÓ|úúú|ÚÚÚ)/i';
          $pattern5 = '/(1111|2222|3333|4444|5555|6666|7777|8888|9999|0000)/i';
          $pattern6 = '/(conchetumare|mierda|weon|puto|puta|culiao|hueon|CONCHETUMARE|MIERDA|WEON|PUTO|PUTA|CULIAO|HUEON|maraca|MARACA|maricon|MARICON|chupalo|CHUPALO)/i';
          $pattern7 ='/^([a-zA-ZñÑáéíóú0-9º°\.\,\'\"\)\(\-\@\:\/\+]+([[:space:][:punct:]]{0,2}[a-zA-ZñÑáéíóú0-9º°\.\,\'\"\)\(\-\@\:\/\+?!]+)*)$/';
          $pattern8 ='/^([0-9º°\.\,\'\"\)\(\-\@\:\/\+]+)$/';

          if(!preg_match($pattern7, $this->$attribute))$this->addError($attribute,'Verifique que su texto tenga al menos una palabra.');
          if(preg_match($pattern8, $this->$attribute) )$this->addError($attribute,'Debe ingresar una palabra');

          if(preg_match($pattern2, $this->$attribute) OR preg_match($pattern3, $this->$attribute) OR preg_match($pattern4, $this->$attribute) OR preg_match($pattern5, $this->$attribute) OR preg_match($pattern6, $this->$attribute))
          $this->addError($attribute,'Verifique el texto ingresado');

      }
}
