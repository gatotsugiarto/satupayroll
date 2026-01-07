<?php

namespace common\modules\satupayroll\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use common\modules\master\models\Company;
use common\modules\auth\models\Member; // sesuaikan kalau namespace berbeda
use common\modules\master\models\StatusActive; // untuk relasi status

class Client extends ActiveRecord
{
    public static function tableName()
    {
        return 'client';
    }

    public function behaviors()
    {
        return [
            // created_at & updated_at -> NOW()
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            // created_by & updated_by -> user id
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['company_id', 'client_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['client'], 'required'],
            [['status_id'], 'default', 'value' => 1],
            [['created_at', 'updated_at'], 'safe'],
            [['client'], 'string', 'max' => 150],
            [['description'], 'string', 'max' => 255],

            // FK: company_id → company.id
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],

            // Self Reference FK: client_id → client.id
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company',
            'client' => 'Client Name',
            'description' => 'Description',
            'client_id' => 'Parent Client',
            'status_id' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    // Self reference master → parent client
    public function getClient0()
    {
        return $this->hasOne(self::class, ['id' => 'client_id']);
    }

    // Child clients → banyak turunan
    public function getClients()
    {
        return $this->hasMany(self::class, ['client_id' => 'id']);
    }

    // Relasi ke Company
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    // Relasi ke Member
    public function getMembers()
    {
        return $this->hasMany(Member::class, ['client_id' => 'id']);
    }

    // 🔥 Relasi ke status_active
    public function getStatus()
    {
        return $this->hasOne(StatusActive::class, ['id' => 'status_id']);
    }
}
