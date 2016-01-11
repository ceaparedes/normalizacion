<?php

namespace app\models;

use Yii;
use app\models\EstadoSolucionReclamoSugerencia;

/**
 * This is the model class for table "SOLUCION_RECLAMO_SUGERENCIA".
 *
 * @property integer $SRS_ID
 * @property string $USU_RUT
 * @property string $REC_NUMERO
 * @property integer $ESR_ID
 * @property string $SRS_VISTO_BUENO
 * @property string $SRS_COMENTARIO
 * @property string $SRS_ANTECEDENTES
 * @property string $SRS_FECHA_RESPUESTA
 * @property string $SRS_FECHA_ENVIO
 * @property string $SRS_RESULTADOS
 *
 * @property DERIVACIONRECLAMOSUGERENCIA[] $dERIVACIONRECLAMOSUGERENCIAs
 * @property SACSAP[] $sACSAPs
 * @property SOLICITUDDOCUMENTO[] $sOLICITUDDOCUMENTOs
 * @property USUARIO $uSURUT
 * @property RECLAMOSUGERENCIA $rECNUMERO
 * @property ESTADOSOLUCIONRECLAMOSUGERENCIA $eSR
 */
class SolucionReclamoSugerencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SOLUCION_RECLAMO_SUGERENCIA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_RUT', 'REC_NUMERO', 'ESR_ID', 'SRS_COMENTARIO'], 'required'],
            [['USU_RUT', 'REC_NUMERO', 'SRS_VISTO_BUENO', 'SRS_COMENTARIO', 'SRS_ANTECEDENTES', 'SRS_RESULTADOS'], 'string'],
            [['SRS_FECHA_RESPUESTA', 'SRS_FECHA_ENVIO', 'ESR_ID'], 'safe'],
            [['SRS_COMENTARIO'],'textValidate'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SRS_ID' => 'Solución Nº',
            'USU_RUT' => 'Rut Usuario',
            'REC_NUMERO' => 'Número Reclamo',
            'ESR_ID' => 'Estado',
            'SRS_VISTO_BUENO' => 'Visto  Bueno',
            'SRS_COMENTARIO' => 'Comentario',
            'SRS_ANTECEDENTES' => 'Antecedentes',
            'SRS_FECHA_RESPUESTA' => 'Fecha  Respuesta',
            'SRS_FECHA_ENVIO' => 'Fecha  Envio',
            'SRS_RESULTADOS' => 'Resultados',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDERIVACIONRECLAMOSUGERENCIAs()
    {
        return $this->hasMany(DERIVACIONRECLAMOSUGERENCIA::className(), ['SRS_ID' => 'SRS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSACSAPs()
    {
        return $this->hasMany(SACSAP::className(), ['SRS_ID' => 'SRS_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSOLICITUDDOCUMENTOs()
    {
        return $this->hasMany(SOLICITUDDOCUMENTO::className(), ['SRS_ID' => 'SRS_ID']);
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
    public function getRECNUMERO()
    {
        return $this->hasOne(RECLAMOSUGERENCIA::className(), ['REC_NUMERO' => 'REC_NUMERO']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getESR()
    {
        return $this->hasOne(ESTADOSOLUCIONRECLAMOSUGERENCIA::className(), ['ESR_ID' => 'ESR_ID']);
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
