<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "admin_company".
 *
 * @property int $id
 * @property string $name
 * @property string $TIN
 * @property string $general_director
 * @property string $address
 * @property int $status
 *
 * @property Company $company
 * @property array $contacts
 */
class AdminCompany extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'TIN', 'general_director', 'address', 'status'], 'required'],
            [['name', 'TIN', 'general_director', 'address'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'TIN' => 'ИНН',
            'general_director' => 'Генеральный директор',
            'address' => 'Адрес',
            'status' => 'Статус',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['admin_company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['admin_company_id' => 'id']);
    }
}
