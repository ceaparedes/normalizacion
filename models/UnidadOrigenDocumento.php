<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "UNIDAD_ORIGEN_DOCUMENTO".
 *
 * @property integer $UOD_ID
 * @property string $UOD_UNIDAD
 * @property string $UOD_SEDE
 *
 * @property DOCUMENTO[] $dOCUMENTOs
 */
class UnidadOrigenDocumento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UNIDAD_ORIGEN_DOCUMENTO';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UOD_ID'], 'required'],
            [['UOD_ID'], 'integer'],
            [['UOD_UNIDAD', 'UOD_SEDE'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'UOD_ID' => 'Uod  ID',
            'UOD_UNIDAD' => 'Uod  Unidad',
            'UOD_SEDE' => 'Uod  Sede',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDOCUMENTOs()
    {
        return $this->hasMany(DOCUMENTO::className(), ['UOD_ID' => 'UOD_ID']);
    }
}
