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
    public $file;
    public $visto_bueno_normalizacion;
    public $visto_bueno_revisor;
    public $visto_bueno_aprobador;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EBD_ID'], 'required'],
            [['EBD_ID'], 'integer'],
            [['SOL_ID'], 'string'],
            [['BDO_FECHA_ENVIO', 'BDO_FECHA_RESPUESTA','visto_bueno_normalizacion'], 'safe'],
            [['file'],'file', 'skipOnEmpty' => false, 'extensions' => 'doc, docx, pdf , xls, xlsx']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'BDO_ID' => 'ID',
            'EBD_ID' => 'Estado Borrador',
            'SOL_ID' => 'Solicitud Nº',
            'BDO_FECHA_ENVIO' => 'Fecha  Envio',
            'BDO_FECHA_RESPUESTA' => 'Fecha  Respuesta',
            'file'=> 'Borrador Documento',
            'visto_bueno_normalizacion'=>'visto_bueno',
            'visto_bueno_revisor'=>'visto_bueno',
            'visto_bueno_aprobador'=>'visto_bueno',
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
