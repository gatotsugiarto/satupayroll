<?php

namespace common\modules\payroll\models;

use Yii;

use common\modules\master\models\Employee;

/**
 * This is the model class for table "employee_join_resign".
 *
 * @property int $id
 * @property int $identity_id
 * @property string|null $e_number
 * @property string $fullname
 * @property string $division
 * @property string $jabatan
 * @property string|null $upload_date
 * @property string|null $referral_code
 * @property int $status_id
 * @property string|null $created_at
 * @property int|null $created_by
 * @property string|null $updated_at
 * @property int|null $updated_by
 */
class EmployeeJoinResign extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_join_resign';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['identity_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['fullname', 'division', 'jabatan'], 'required'],
            [['upload_date', 'created_at', 'updated_at'], 'safe'],
            [['e_number'], 'string', 'max' => 50],
            [['fullname', 'division', 'jabatan', 'referral_code'], 'string', 'max' => 255],
            [['e_number'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'identity_id' => 'Identity ID',
            'e_number' => 'E Number',
            'fullname' => 'Fullname',
            'division' => 'Division',
            'jabatan' => 'Jabatan',
            'upload_date' => 'Upload Date',
            'referral_code' => 'Referral Code',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function list_resign()
    {
        if(($this->identity_id == 0) && ($this->status_id == 1)){
            $model = Employee::findOne($this->id);
            if($model){
                // if($model->status_id == 1){
                //     return true;    
                // }else{
                //     return false;
                // }
                return true;    
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function action_resign()
    {
        if(($this->identity_id == 0) && ($this->status_id == 1)){
            $model = Employee::findOne($this->id);
            if($model){
                if($model->status_id == 1){
                    return 1;    
                }else{
                    return 2;
                }
            }else{
                return 2;
            }
        }else{
            return 2;
        }
    }
}
