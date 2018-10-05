<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public_contact".
 *
 * @property int $id
 * @property string $name
 * @property string $phone_number
 * @property string $email
 * @property int $company_id
 * @property int $contact_id
 *
 * @property Company $company
 * @property Contact $contact
 */
class PublicContact extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'public_contact';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone_number', 'email', 'company_id', 'contact_id'], 'required'],
            [['company_id', 'contact_id'], 'integer'],
            [['name', 'phone_number', 'email'], 'string', 'max' => 255],
            [['contact_id'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::className(), 'targetAttribute' => ['company_id' => 'id']],
            [['contact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Contact::className(), 'targetAttribute' => ['contact_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'phone_number' => 'Телефон',
            'email' => 'Электронная почта',
            'company_id' => 'Company ID',
            'contact_id' => 'Contact ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }
}
