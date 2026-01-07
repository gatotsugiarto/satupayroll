<?php

namespace common\modules\master\models;

use Yii;

use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

use common\components\behaviors\TokenProtectedFormBehavior;
use common\components\behaviors\LoggableBehavior;

use common\modules\master\models\Client;
use common\modules\master\models\Member;
use common\modules\master\models\StatusActive;
use common\modules\auth\models\User;

class Company extends ActiveRecord
{
    public static function tableName()
    {
        return 'company';
    }

    public function behaviors()
    {
        if ($this instanceof CompanySearch) {
            return [];
        }
    
        return [
            // created_at & updated_at => NOW()
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
            // created_by & updated_by => user login
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            // token protection untuk form
            'tokenProtection' => [
                'class' => TokenProtectedFormBehavior::class,
                'tokenAttribute' => 'form_token',
                'sessionKey' => 'company_token',
            ],
            // log activity otomatis
            [
                'class' => LoggableBehavior::class,
                'modelName' => 'Company', // opsional, default pakai nama tabel
            ],
        ];
    }

    public function rules()
    {
        return [
            [['code', 'company'], 'required'],
            [['status_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 10],
            [['company'], 'string', 'max' => 150],
            [['status_id'], 'default', 'value' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'company' => 'Company',
            'description' => 'Description',
            'status_id' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    // Relasi ke Client
    public function getClients()
    {
        return $this->hasMany(Client::class, ['company_id' => 'id']);
    }

    // Relasi ke Member
    public function getMembers()
    {
        return $this->hasMany(Member::class, ['company_id' => 'id']);
    }

    // Relasi ke status_active
    public function getStatus()
    {
        return $this->hasOne(StatusActive::class, ['id' => 'status_id']);
    }

    // Relasi ke user created
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    // Relasi ke user updated
    public function getUpdatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public static function dropdown()
    {
        static $dropdown;
        if ($dropdown === null) {
            //$dropdown[0] = 'None';
            $models = static::find()->all();
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->company;
            }
        }
        
        return $dropdown;
    }
}
