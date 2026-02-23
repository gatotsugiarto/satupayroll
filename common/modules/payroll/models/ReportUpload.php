<?php

namespace common\modules\payroll\models;

use Yii;

class ReportUpload extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['baru', 'resign', 'tetap', 'pkwt', 'karyawan', 'lembur', 'reimburse', 'revisi_absensi', 'unpaid_leave', 'absensi', 'keterlambatan', 'thr', 'no_salary', 'no_npwp', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['upload_date', 'join_date_prorate', 'resign_prorate', 'created_at', 'updated_at'], 'safe'],
            [['referral_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'baru' => 'Baru',
            'resign' => 'Resign',
            'tetap' => 'Tetap',
            'pkwt' => 'Pkwt',
            'karyawan' => 'Karyawan',
            'lembur' => 'Lembur',
            'reimburse' => 'Reimburse',
            'revisi_absensi' => 'Revisi Absensi',
            'unpaid_leave' => 'Unpaid Leave',
            'absensi' => 'Absensi',
            'keterlambatan' => 'Keterlambatan',
            'thr' => 'THR',
            'join_date_prorate' => 'Join Date Prorate',
            'resign_prorate' => 'Resign Prorate',
            'no_salary' => 'No Salary',
            'no_npwp' => 'No NPWP',
            'upload_date' => 'Upload Date',
            'referral_code' => 'Referral Code',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
