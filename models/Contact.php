<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contact".
 *
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property string $email
 * @property int $admin_company_id
 *
 * @property AdminCompany $adminCompany
 */
class Contact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone_number', 'email', 'admin_company_id'], 'required'],
            [['admin_company_id'], 'integer'],
            [['name', 'phone_number', 'email'], 'string', 'max' => 255],
            [['admin_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminCompany::className(), 'targetAttribute' => ['admin_company_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' =>  'ID',
            'name' =>'Имя',
            'phone_number' => 'Телефон',
            'email' =>  'Электронная почта',
            'admin_company_id' =>  'Admin Company ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdminCompany()
    {
        return $this->hasOne(AdminCompany::className(), ['id' => 'admin_company_id']);
    }
}
