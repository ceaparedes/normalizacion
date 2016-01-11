<?php

namespace app\models;

use Yii;
use app\models\EstadoReclamoSugerencia;

/**
 * This is the model class for table "HISTORIAL_ESTADOS".
 *
 * @property integer $HES_ID
 * @property string $REC_NUMERO
 * @property integer $ERS_ID
 * @property string $USU_RUT
 * @property string $HES_FECHA_HORA
 * @property string $HES_COMENTARIO
 *
 * @property USUARIO $uSURUT
 * @property RECLAMOSUGERENCIA $rECNUMERO
 * @property ESTADORECLAMOSUGERENCIA $eRS
 */
class HistorialEstados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'HISTORIAL_ESTADOS';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['REC_NUMERO', 'USU_RUT', 'HES_COMENTARIO'], 'string'],

            [['HES_FECHA_HORA', 'ERS_ID'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HES_ID' => 'Historial Nº',
            'REC_NUMERO' => 'Número Reclamo',
            'ERS_ID' => 'Estado',
            'USU_RUT' => 'Usuario',
            'HES_FECHA_HORA' => 'Fecha',
            'HES_COMENTARIO' => 'Comentario',
        ];
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
    public function getERS()
    {
        return $this->hasOne(ESTADORECLAMOSUGERENCIA::className(), ['ERS_ID' => 'ERS_ID']);
    }
}
