<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ADJUNTOS".
 *
 * @property integer $ADJ_ID
 * @property string $SOL_ID
 * @property string $PAU_ID
 * @property integer $DRS_ID
 * @property integer $DSD_ID
 * @property string $ADJ_TIPO
 * @property string $ADJ_URL
 *relaciones (joins)
 * @property DERIVACIONSOLICITUDDOCUMENTO $dSD
 * @property PLANAUDITORIA $pAU
 * @property SOLICITUDDOCUMENTO $sOL
 * @property DERIVACIONRECLAMOSUGERENCIA $dRS
 * @property RECLAMOSUGERENCIA $rECNUMERO
 * @property BORRADORDOCUMENTO[] $bORRADORDOCUMENTOs
 */
class Adjuntos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ADJUNTOS';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SOL_ID', 'PAU_ID', 'ADJ_TIPO', 'ADJ_URL'], 'string'],
            [['DRS_ID', 'DSD_ID'], 'integer'],
            [['REC_NUMERO'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ADJ_ID' => 'Adj  ID',
            'SOL_ID' => 'Sol  ID',
            'PAU_ID' => 'Pau  ID',
            'DRS_ID' => 'Drs  ID',
            'DSD_ID' => 'Dsd  ID',
            'REC_NUMERO' => 'Rec Numero',
            'ADJ_TIPO' => 'Tipo',
            'ADJ_URL' => 'Adjunto',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDSD()
    {
        return $this->hasOne(DERIVACIONSOLICITUDDOCUMENTO::className(), ['DSD_ID' => 'DSD_ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPAU()
    {
        return $this->hasOne(PLANAUDITORIA::className(), ['PAU_ID' => 'PAU_ID']);
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
    public function getDRS()
    {
        return $this->hasOne(DERIVACIONRECLAMOSUGERENCIA::className(), ['DRS_ID' => 'DRS_ID']);
    }

    public function getRECNUMERO()
    {
        return $this->hasOne(RECLAMOSUGERENCIA::className(), ['REC_NUMERO' => 'REC_NUMERO']);
    }

    public function getBORRADORDOCUMENTOs()
    {
        return $this->hasMany(BORRADORDOCUMENTO::className(), ['EBD_ID' => 'EBD_ID']);
    }
}
