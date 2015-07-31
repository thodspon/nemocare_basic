<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%amphur}}".
 *
 * @property string $provcode
 * @property string $amphurcode
 * @property string $amphurname
 */
class Amphur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%amphur}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('db_nemo');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amphurcode'], 'required'],
            [['provcode'], 'string', 'max' => 50],
            [['amphurcode'], 'string', 'max' => 4],
            [['amphurname'], 'string', 'max' => 30],
            [['amphurname'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'provcode' => 'Provcode',
            'amphurcode' => 'Amphurcode',
            'amphurname' => 'Amphurname',
        ];
    }

    /**
     * @inheritdoc
     * @return AmphurQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AmphurQuery(get_called_class());
    }
}
