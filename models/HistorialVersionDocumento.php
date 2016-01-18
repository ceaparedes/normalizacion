<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "HISTORIAL_VERSION_DOCUMENTO".
 *
 * @property integer $HVD_ID
 * @property string $USU_RUT
 * @property integer $DOC_CODIGO
 * @property integer $VER_ID
 * @property string $HVD_FECHA_HORA
 * @property string $HVD_COMENTARIO
 * @property string $HVD_VISTO_BUENO
 *
 * @property VERSIONDOCUMENTO $vER
 * @property USUARIO $uSURUT
 * @property VERSIONDOCUMENTO $dOCCODIGO
 */
class HistorialVersionDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'HISTORIAL_VERSION_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['USU_RUT', 'HVD_COMENTARIO', 'HVD_VISTO_BUENO'], 'string'],
            [['DOC_CODIGO', 'VER_ID'], 'integer'],
            [['HVD_FECHA_HORA'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HVD_ID' => 'Hvd  ID',
            'USU_RUT' => 'Usu  Rut',
            'DOC_CODIGO' => 'Doc  Codigo',
            'VER_ID' => 'Ver  ID',
            'HVD_FECHA_HORA' => 'Hvd  Fecha  Hora',
            'HVD_COMENTARIO' => 'Hvd  Comentario',
            'HVD_VISTO_BUENO' => 'Hvd  Visto  Bueno',
        ];
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
    public function getUSURUT()
    {
        return $this->hasOne(USUARIO::className(), ['USU_RUT' => 'USU_RUT']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOCCODIGO()
    {
        return $this->hasOne(VERSIONDOCUMENTO::className(), ['DOC_CODIGO' => 'DOC_CODIGO']);
    }
}
