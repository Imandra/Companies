<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $TIN
 * @property string $general_director
 * @property string $address
 * @property int $admin_company_id
 *
 * @property AdminCompany $adminCompany
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'TIN', 'general_director', 'address', 'admin_company_id'], 'required'],
            [['admin_company_id'], 'integer'],
            [['name', 'TIN', 'general_director', 'address'], 'string', 'max' => 255],
            [['admin_company_id'], 'unique'],
            [['admin_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminCompany::className(), 'targetAttribute' => ['admin_company_id' => 'id']],
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
            'admin_company_id' => 'Admin Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminCompany()
    {
        return $this->hasOne(AdminCompany::className(), ['id' => 'admin_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContacts()
    {
        return $this->hasMany(Contact::className(), ['admin_company_id' => 'id']);
    }
}
