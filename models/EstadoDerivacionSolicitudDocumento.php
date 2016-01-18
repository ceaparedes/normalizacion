<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ESTADO_DERIVACION_SOLICITUD_DOCUMENTO".
 *
 * @property integer $EDS_ID
 * @property string $EDS_ESTADO
 *
 * @property DERIVACIONSOLICITUDDOCUMENTO[] $dERIVACIONSOLICITUDDOCUMENTOs
 */
class EstadoDerivacionSolicitudDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ESTADO_DERIVACION_SOLICITUD_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EDS_ESTADO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EDS_ID' => 'Eds  ID',
            'EDS_ESTADO' => 'Eds  Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDERIVACIONSOLICITUDDOCUMENTOs()
    {
        return $this->hasMany(DERIVACIONSOLICITUDDOCUMENTO::className(), ['EDS_ID' => 'EDS_ID']);
    }
}
