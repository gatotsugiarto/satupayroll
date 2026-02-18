<?php

namespace common\modules\payroll\models;

use Yii;

use PhpOffice\PhpSpreadsheet\IOFactory;

use common\modules\master\models\UploadItem;


class EmployeeUpload extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['site_office_id', 'e_number', 'join_date', 'gender_id', 'gender', 'level_jabatan_id', 'email', 'npwp_id', 'bpjs_tk', 'bpjs_kes', 'jkk', 'employee_status_id', 'new_join_date', 'resign_date', 'thr', 'upload_date', 'referral_code', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'default', 'value' => null],
            [['working_day'], 'default', 'value' => 0],
            [['status_id'], 'default', 'value' => 1],
            [['bonus'], 'default', 'value' => 0.00],
            [['region_id', 'company_id', 'branch_id', 'site_office_id', 'department_id', 'division_id', 'gender_id', 'marital_status_id', 'family_status_id', 'ptkp_id', 'level_jabatan_id', 'jabatan_id', 'grade_id', 'is_npwp', 'jkk_id', 'bank_id', 'employee_status_id', 'join_date_prorate', 'resign_prorate', 'is_bpjs', 'thr', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['region', 'company', 'branch', 'site_office', 'department', 'division', 'fullname', 'marital_status', 'family_status', 'ptkp', 'level_jabatan', 'jabatan', 'grade', 'bank', 'bank_no', 'employee_status'], 'required'],
            [['join_date', 'new_join_date', 'resign_date', 'upload_date', 'created_at', 'updated_at'], 'safe'],
            [['bpjs_tk', 'bpjs_kes', 'address'], 'string'],
            [['working_day', 'overtime', 'claim', 'revisi_absensi', 'unpaid_leave', 'absensi', 'terlambat', 'bonus'], 'number'],
            [['region', 'company', 'branch', 'site_office', 'department', 'division', 'fullname', 'gender', 'marital_status', 'family_status', 'ptkp', 'level_jabatan', 'jabatan', 'grade', 'npwp_id', 'jkk', 'bank', 'bank_no', 'employee_status', 'referral_code'], 'string', 'max' => 255],
            [['e_number'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
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
            'region_id' => 'Region ID',
            'region' => 'Region',
            'company_id' => 'Company ID',
            'company' => 'Company',
            'branch_id' => 'Branch ID',
            'branch' => 'Branch',
            'site_office_id' => 'Site Office ID',
            'site_office' => 'Site Office',
            'department_id' => 'Department ID',
            'department' => 'Department',
            'division_id' => 'Division ID',
            'division' => 'Division',
            'e_number' => 'E Number',
            'fullname' => 'Fullname',
            'join_date' => 'Join Date',
            'gender_id' => 'Gender ID',
            'gender' => 'Gender',
            'marital_status_id' => 'Marital Status ID',
            'marital_status' => 'Marital Status',
            'family_status_id' => 'Family Status ID',
            'family_status' => 'Family Status',
            'ptkp_id' => 'Ptkp ID',
            'ptkp' => 'Ptkp',
            'level_jabatan_id' => 'Level Jabatan ID',
            'level_jabatan' => 'Level Jabatan',
            'jabatan_id' => 'Jabatan ID',
            'jabatan' => 'Jabatan',
            'grade_id' => 'Grade ID',
            'grade' => 'Grade',
            'email' => 'Email',
            'is_npwp' => 'Is Npwp',
            'npwp_id' => 'Npwp ID',
            'bpjs_tk' => 'Bpjs Tk',
            'bpjs_kes' => 'Bpjs Kes',
            'jkk_id' => 'Jkk ID',
            'jkk' => 'Jkk',
            'bank_id' => 'Bank ID',
            'bank' => 'Bank',
            'bank_no' => 'Bank No',
            'employee_status_id' => 'Employee Status ID',
            'employee_status' => 'Employee Status',
            'join_date_prorate' => 'Join Date Prorate',
            'new_join_date' => 'New Join Date',
            'resign_prorate' => 'Resign Prorate',
            'resign_date' => 'Resign Date',
            'working_day' => 'Working Day',
            'is_bpjs' => 'Is Bpjs',
            'overtime' => 'Overtime',
            'claim' => 'Claim',
            'revisi_absensi' => 'Revisi Absensi',
            'unpaid_leave' => 'Unpaid Leave',
            'absensi' => 'Absensi',
            'terlambat' => 'Terlambat',
            'thr' => 'Thr',
            'bonus' => 'Bonus',
            'address' => 'Address',
            'upload_date' => 'Upload Date',
            'referral_code' => 'Referral Code',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function saveRecords($inputFile, $referral_code) {
        
        // $modelPayroll = new Payroll();

        try {
            $spreadsheet = IOFactory::load($inputFile);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            $sql = "TRUNCATE TABLE employee_upload";
            \Yii::$app->db->createCommand($sql)->execute();

            $upload_date = date('Y-m-d');

            foreach ($rows as $index => $row) {
                if ($index == 0) { // Lewati header (baris pertama)
                    continue;
                }

                $EmployeeUpload = new self();
                $EmployeeUpload->id = $row[0];
                $EmployeeUpload->region_id = $row[1];
                $EmployeeUpload->region = $row[2];
                $EmployeeUpload->company_id = $row[3];
                $EmployeeUpload->company = $row[4];
                $EmployeeUpload->branch_id = $row[5];
                $EmployeeUpload->branch = $row[6];
                $EmployeeUpload->site_office_id = $row[7];
                $EmployeeUpload->site_office = $row[8];
                $EmployeeUpload->department_id = $row[9];
                $EmployeeUpload->department = $row[10];
                $EmployeeUpload->division_id = $row[11];
                $EmployeeUpload->division = $row[12];
                $EmployeeUpload->e_number = $row[13];
                $EmployeeUpload->fullname = $row[14];
                $EmployeeUpload->join_date = $row[15];
                $EmployeeUpload->gender_id = $row[16];
                $EmployeeUpload->gender = $row[17];
                $EmployeeUpload->marital_status_id = $row[18];
                $EmployeeUpload->marital_status = $row[19];
                $EmployeeUpload->family_status_id = $row[20];
                $EmployeeUpload->family_status = $row[21];
                $EmployeeUpload->ptkp_id = $row[22];
                $EmployeeUpload->ptkp = $row[23];
                $EmployeeUpload->level_jabatan_id = $row[24];
                $EmployeeUpload->level_jabatan = $row[25];
                $EmployeeUpload->jabatan_id = $row[26];
                $EmployeeUpload->jabatan = $row[27];
                $EmployeeUpload->grade_id = $row[28];
                $EmployeeUpload->grade = $row[29];
                $EmployeeUpload->email = $row[30];
                $EmployeeUpload->is_npwp = $row[31];
                $EmployeeUpload->npwp_id = $row[32];
                $EmployeeUpload->bpjs_tk = null;
                $EmployeeUpload->bpjs_kes = null;
                $EmployeeUpload->jkk_id = $row[33];
                $EmployeeUpload->jkk = $row[34];
                $EmployeeUpload->bank_id = $row[35];
                $EmployeeUpload->bank = $row[36];
                $EmployeeUpload->bank_no = $row[37];
                $EmployeeUpload->employee_status_id = $row[38];
                $EmployeeUpload->employee_status = $row[39];
                $EmployeeUpload->join_date_prorate = $row[40];
                $EmployeeUpload->new_join_date = $row[41];
                $EmployeeUpload->resign_prorate = $row[42];
                $EmployeeUpload->resign_date = $row[43];
                $EmployeeUpload->working_day = $row[44];
                $EmployeeUpload->is_bpjs = $row[45];
                $EmployeeUpload->overtime = self::parseExcelNumber($row[46]);
                $EmployeeUpload->claim = self::parseExcelNumber($row[47]);
                $EmployeeUpload->revisi_absensi = self::parseExcelNumber($row[48]);
                $EmployeeUpload->unpaid_leave = $row[49];
                $EmployeeUpload->terlambat = self::parseExcelNumber($row[50]);
                $EmployeeUpload->absensi = $row[51];
                $EmployeeUpload->thr = $row[52];
                $EmployeeUpload->bonus = self::parseExcelNumber($row[53]);
                $EmployeeUpload->address = $row[54];
                $EmployeeUpload->upload_date = $upload_date;
                $EmployeeUpload->referral_code = $referral_code;

                $EmployeeUpload->save(false);
            }

            $EmployeeUpload->report_upload($referral_code, $upload_date);
            self::adjust_salary_from_upload();
            self::adjust_employee_pending_ptkp();
            // $modelPayroll->proses_additional($referral_code, $upload_date);

            // EmployeeHistory::create($referral_code, "Import Payroll", "Import data payroll telah berhasil [$referral_code]");
            // // return false;
            // Yii::$app->session->setFlash('success', 'Import data payroll telah berhasil');
            // return $this->redirect(['reportupload', 'referral_code' => $referral_code]);

            return true;
        } catch (\Exception $e) {
            // Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return $e;
        }
    }

    public static function adjust_salary_from_upload($employee_id=0)
    {
        $model = UploadItem::find()->all();
        foreach($model as $rows){
            $field_name = $rows->upload_field;
            $payroll_item_id = $rows->payroll_item_id;
            $operator_info = $rows->operator_info;

            // print "$field_name - $payroll_item_id - $operator_info <br />";

            if($employee_id){
                // Delete Source salary
                $sql = "DELETE t.* FROM salary t INNER JOIN employee t2 ON t2.id = $employee_id AND t.employee_id = t2.id AND t.status_id = 1 AND t2.status_id = 1 AND t.payroll_item_id = $payroll_item_id AND t.insert_by = 'IMPORT' INNER JOIN employee_upload t3 ON t.employee_id = t3.id AND t3.$field_name $operator_info AND t.updated_by = 1";
                \Yii::$app->db->createCommand($sql)->execute();

                // Insert Source salary
                $sql = "INSERT INTO salary (employee_id, payroll_item_id, amount, insert_by, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, $payroll_item_id AS payroll_item_id, t2.$field_name, 'IMPORT' AS insert_by, 1 AS status_id, NOW(), 1, NOW(), 1 FROM employee t INNER JOIN employee_upload t2 ON t.id = $employee_id AND t.id = t2.id AND t.status_id = 1 AND t2.status_id = 1 AND t2.$field_name $operator_info";
                \Yii::$app->db->createCommand($sql)->execute();
            }else{
                // Delete Source salary
                $sql = "DELETE t.* FROM salary t INNER JOIN employee t2 ON t.employee_id = t2.id AND t.status_id = 1 AND t2.status_id = 1 AND t.payroll_item_id = $payroll_item_id AND t.insert_by = 'IMPORT' INNER JOIN employee_upload t3 ON t.employee_id = t3.id AND t3.$field_name $operator_info AND t.updated_by = 1";
                \Yii::$app->db->createCommand($sql)->execute();

                // Insert Source salary
                $sql = "INSERT INTO salary (employee_id, payroll_item_id, amount, insert_by, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, $payroll_item_id AS payroll_item_id, t2.$field_name, 'IMPORT' AS insert_by, 1 AS status_id, NOW(), 1, NOW(), 1 FROM employee t INNER JOIN employee_upload t2 ON t.id = t2.id AND t.status_id = 1 AND t2.status_id = 1 AND t2.$field_name $operator_info";
                \Yii::$app->db->createCommand($sql)->execute();
            }
        }

        return 1;
        // die;   
    }

    public static function adjust_employee_pending_ptkp()
    {
        $sql = "INSERT INTO employee_pending SELECT 0, e.id, e.e_number, eu.marital_status_id, eu.marital_status, eu.family_status_id, eu.family_status, eu.ptkp_id, eu.ptkp, DATE(CONCAT(YEAR(CURDATE()) + 1, '-01-01')), 'PTKP', 1, NOW(), 1, NOW(), 1 FROM employee e JOIN employee_upload eu ON eu.id = e.id WHERE (e.marital_status_id <> eu.marital_status_id OR e.family_status_id <> eu.family_status_id) AND NOT EXISTS (SELECT 1 FROM employee_pending ep WHERE ep.employee_id = e.id AND ep.status_id = 1 AND ep.pending_TYPE = 'PTKP')";
        \Yii::$app->db->createCommand($sql)->execute();

        return 1;
    }

    public static function parseExcelNumber($raw) {
        // Hilangkan spasi
        $raw = trim($raw);
        $clean = str_replace(['.', ','],['', '.'],$raw);
        // Hilangkan koma ribuan
        $raw = str_replace(',', '', $raw);
        return (float) $raw;
        // return $raw;
    }

    public function report_upload($referral_code, $upload_date)
    {
        $sql = "TRUNCATE TABLE report_upload";
        \Yii::$app->db->createCommand($sql)->execute();

        $sql = "INSERT INTO report_upload
SELECT 0, j.baru, k.resign, a.permanen, b.pkwt, c.karyawan, d.lembur, e.reimburse, f.revisi_absensi, g.unpaid_leave, h.absensi, i.terlambat, l.thr, m.join_date_prorate, o.resign_prorate, n.no_salary, '$upload_date', '$referral_code', 1, NOW(), 1, NOW(), 1 
FROM 
(SELECT COUNT(*) AS permanen FROM employee_upload WHERE employee_status_id < 3) a, 
(SELECT COUNT(*) AS pkwt FROM employee_upload WHERE employee_status_id > 2) b, 
(SELECT COUNT(*) AS karyawan FROM employee_upload) c, 
(SELECT COUNT(*) AS lembur FROM employee_upload WHERE overtime > 0) d, 
(SELECT COUNT(*) AS reimburse FROM employee_upload WHERE claim > 0) e, 
(SELECT COUNT(*) AS revisi_absensi FROM employee_upload WHERE revisi_absensi > 0) f, 
(SELECT COUNT(*) AS unpaid_leave FROM employee_upload WHERE unpaid_leave > 0) g, 
(SELECT COUNT(*) AS absensi FROM employee_upload WHERE absensi > 0) h, 
(SELECT COUNT(*) AS terlambat FROM employee_upload WHERE terlambat > 0) i,
-- (SELECT COUNT(*) AS baru FROM employee_upload a LEFT JOIN employee b ON a.id = b.id WHERE b.id IS NULL) j, 
(SELECT COUNT(*) AS baru FROM employee_upload WHERE new_join_date IS NOT NULL) j, 
-- (SELECT COUNT(*) AS resign FROM employee a LEFT JOIN employee_upload b ON a.id = b.id WHERE b.id IS NULL) k,
(SELECT COUNT(*) AS resign FROM employee_upload WHERE resign_date IS NOT NULL) k,
(SELECT COUNT(*) AS thr FROM employee_upload WHERE bonus > 0) l,
(SELECT COUNT(*) AS join_date_prorate FROM employee_upload WHERE join_date_prorate > 0) m,
(SELECT COUNT(*) AS resign_prorate FROM employee_upload WHERE resign_prorate  > 0) o,
(SELECT COUNT(a.id) AS no_salary FROM employee a LEFT JOIN (SELECT employee_id FROM salary WHERE payroll_item_id = 1 AND status_id = 1) b ON a.id = b.employee_id WHERE a.status_id = 1 AND b.employee_id IS NULL) n";
        \Yii::$app->db->createCommand($sql)->execute();

        $sql = "INSERT INTO report_upload SELECT 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, upload_date, referral_code, status_id, created_at, created_by, updated_at, updated_by FROM report_upload WHERE id = 1 AND referral_code = '$referral_code'";
        \Yii::$app->db->createCommand($sql)->execute();

        // Total karyawan aktif
        $sql = "UPDATE report_upload SET karyawan = (SELECT COUNT(*) FROM employee WHERE status_id = 1) WHERE id = 2";
        \Yii::$app->db->createCommand($sql)->execute();

        // Total karyawan pkwt
        $sql = "UPDATE report_upload SET pkwt = (SELECT COUNT(*) FROM employee WHERE status_id = 1 AND employee_status_id = 3) WHERE id = 2";
        \Yii::$app->db->createCommand($sql)->execute();

        // Total karyawan permanent
        $sql = "UPDATE report_upload SET tetap = (SELECT COUNT(*) FROM employee WHERE status_id = 1 AND employee_status_id < 3) WHERE id = 2";
        \Yii::$app->db->createCommand($sql)->execute();

        $sql = "TRUNCATE TABLE employee_join_resign";
        \Yii::$app->db->createCommand($sql)->execute();

        // Karyawan baru
        $sql = "INSERT INTO employee_join_resign SELECT a.id, 1, a.e_number, a.fullname, a.division, a.jabatan, '$upload_date', '$referral_code', 1, NOW(), 1, NOW(), 1 FROM employee_upload a LEFT JOIN employee b ON a.id = b.id WHERE b.id IS NULL";
        \Yii::$app->db->createCommand($sql)->execute();

        // Karyawan resign
        // $sql = "INSERT INTO employee_join_resign SELECT a.id, 0, a.e_number, a.fullname, a.division, a.jabatan, '$upload_date', '$referral_code', 1, NOW(), 1, NOW(), 1 FROM employee a LEFT JOIN employee_upload b ON a.id = b.id WHERE a.status_id = 1 AND b.id IS NULL";
        $sql = "INSERT INTO employee_join_resign SELECT a.id, 0, a.e_number, a.fullname, a.division, a.jabatan, '$upload_date', '$referral_code', 1, NOW(), 1, NOW(), 1 FROM employee a LEFT JOIN employee_upload b ON a.id = b.id WHERE a.status_id = 1 AND b.id IS NULL";
        // print $sql;
        \Yii::$app->db->createCommand($sql)->execute();
    }

    // public function statistic_existing($referral_code)
    // {
    //     $baru = Payroll::baru();
    //     $resign = Payroll::resign();
    //     $tetap = Payroll::tetap();
    //     $pkwt = Payroll::pkwt();
    //     $karyawan = Payroll::total();
    //     $no_salary = Payroll::no_salary();

    //     Payroll::updateResign($referral_code);

    //     Payroll::updatePTKP($referral_code); // PR, ada relasi tiap tahun refresh

    //     // print "$baru || $resign || $tetap || $pkwt || $total || $overtime_index || $claim_reimburse || $revisi_absensi || $unpaid_leave || $alpha || $terlambat || $thr";

    //     $EmployeeUploaded = EmployeeUploaded::findOne(['id' => 2, 'referral_code' => $referral_code]);
    //     if ($EmployeeUploaded) {
    //         $EmployeeUploaded->baru = $baru;
    //         $EmployeeUploaded->resign = $resign;
    //         $EmployeeUploaded->tetap = $tetap;
    //         $EmployeeUploaded->pkwt = $pkwt;
    //         $EmployeeUploaded->karyawan = $karyawan;
    //         $EmployeeUploaded->no_salary = $no_salary;
            
    //         $EmployeeUploaded->save();
    //         // var_dump($EmployeeUploaded->errors);
    //     }
    // }

}
