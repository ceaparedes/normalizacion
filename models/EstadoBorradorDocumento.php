<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ESTADO_BORRADOR_DOCUMENTO".
 *
 * @property integer $EBD_ID
 * @property string $EBD_ESTADO
 *
 * @property BORRADORDOCUMENTO[] $bORRADORDOCUMENTOs
 */
class EstadoBorradorDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ESTADO_BORRADOR_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['EBD_ESTADO'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'EBD_ID' => 'Ebd  ID',
            'EBD_ESTADO' => 'Ebd  Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBORRADORDOCUMENTOs()
    {
        return $this->hasMany(BORRADORDOCUMENTO::className(), ['EBD_ID' => 'EBD_ID']);
    }
}
