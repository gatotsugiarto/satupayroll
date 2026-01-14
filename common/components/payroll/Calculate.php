<?php
namespace common\components\payroll;

use yii\base\Component;


class Calculate extends Component
{
    public static function PayrollGenerateBatch($year, $month, $period_code, $status_id, $user_id)
    {
        /*
        1. DATA
        2. INCOME_FIXED dan INCOME_VAR Pola Sama
        3. ACTUAL_SALARY
         */
        $generate_mode = 'Batch';

        $sql = "DELETE FROM payroll_detail WHERE period_code = '$period_code' AND status_id = 1";
        \Yii::$app->db->createCommand($sql)->execute();

        // DATA
        self::insertSalaryToPayroll($generate_mode, $period_code, $status_id, $user_id);

        // FIXED_INCOME
        self::sumPayrollCategory($category_id=1, $generate_mode, $period_code, $status_id, $user_id);

        // VAR_INCOME
        self::sumPayrollCategory($category_id=2, $generate_mode, $period_code, $status_id, $user_id);

        // OTHER_INCOME
        self::sumSignPayrollCategory($item_id=46, $generate_mode, $period_code, $status_id, $user_id);

        // ACTUAL_SALARY
        self::plusPayrollCategory($item_id=11, $generate_mode, $period_code, $status_id, $user_id);
        
        /**
         * BPJS PERUSAHAAN
         */
        self::calculatePayrollCapParam($item_id=12, $generate_mode, $period_code, $status_id, $user_id); // JHT_PERUSAHAAN
        self::calculatePayrollCapParam($item_id=13, $generate_mode, $period_code, $status_id, $user_id); // JP_PERUSAHAAN
        self::calculatePayrollCapParam($item_id=14, $generate_mode, $period_code, $status_id, $user_id); // JKM
        self::calculatePayrollCapParam($item_id=15, $generate_mode, $period_code, $status_id, $user_id); // JKK
        self::calculatePayrollCapParam($item_id=16, $generate_mode, $period_code, $status_id, $user_id); // BPJS_KES_PERUSAHAAN


        /**
         * BPJS KARYAWAN
         */
        self::calculatePayrollCapParam($item_id=32, $generate_mode, $period_code, $status_id, $user_id); // JHT_KARY
        self::calculatePayrollCapParam($item_id=33, $generate_mode, $period_code, $status_id, $user_id); // JP_KARY
        self::calculatePayrollCapParam($item_id=34, $generate_mode, $period_code, $status_id, $user_id); // BPJS_KES_KARY

        // JKK -> Relate other table
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t3.code, ROUND(t4.amount * t.amount,0) AS amount, t3.type, CONCAT('base=',t.item_code,';percent=',t3.percent,';cap=',t3.cap) AS trace, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN v_employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 15 INNER JOIN jkk t4 ON t2.jkk_id = t4.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // EMPLOYER_BPJS
        self::plusPayrollCategory($item_id=47, $generate_mode, $period_code, $status_id, $user_id);

        // EMPLOYEE_BPJS
        self::plusPayrollCategory($item_id=48, $generate_mode, $period_code, $status_id, $user_id);
        // EMPLOYEE_BPJS_YEAR
        self::plusPayrollCategory($item_id=51, $generate_mode, $period_code, $status_id, $user_id);

        /**
         * BRUTO
         */
        self::plusPayrollCategory($item_id=26, $generate_mode, $period_code, $status_id, $user_id); // BRUTO
        self::plusPayrollCategory($item_id=49, $generate_mode, $period_code, $status_id, $user_id); // BRUTO_YEAR

        /**
         * BIAYA_JABATAN
         */
        self::calculatePayrollCapResult($item_id=50, $generate_mode, $period_code, $status_id, $user_id); // BIAYA_JABATAN


        // TOTAL_BEBAN_PERUSAHAAN
        self::plusPayrollCategory($item_id=27, $generate_mode, $period_code, $status_id, $user_id);

        // BRUTO_TAX
        self::plusPayrollCategory($item_id=28, $generate_mode, $period_code, $status_id, $user_id);

        // Ter  -> TER Category
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, description, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.id, '$period_code' AS period_code, t4.code, t4.name, t4.code, t3.ter, t4.type, NULL, t4.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM v_employee t INNER JOIN ptkp t2 ON t2.id = t.ptkp_id INNER JOIN ter t3 ON t3.id = t2.ter_id INNER JOIN payroll_item t4 ON t4.status_id = 1 AND t4.id = 29 INNER JOIN v_employee_profile_item t5 ON t.id = t5.employee_id AND t5.item_id = t4.id";
        \Yii::$app->db->createCommand($sql)->execute();

        // TER_RATE
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t3.code, t4.ter AS amount, t3.type, CONCAT('base=',t.item_code,';percent=',t3.percent,';cap=',t3.cap) AS trace, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN v_employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 30 INNER JOIN ter_prosen t4 ON t2.ptkp_id = t4.ptkp_id AND t.amount BETWEEN t4.bruto_from AND t4.bruto_to INNER JOIN v_employee_profile_item t5 ON t2.id = t5.employee_id AND t5.item_id = t3.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // PPH21_GROSS_UP
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t5.code, ROUND((t4.ter * t.amount),0) AS amount, t3.type, CONCAT('base=',t.item_code,';percent=',t3.percent,';cap=',t3.cap) AS trace, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN v_employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 31 INNER JOIN ter_prosen t4 ON t2.ptkp_id = t4.ptkp_id AND t.amount BETWEEN t4.bruto_from AND t4.bruto_to INNER JOIN payroll_category t5 ON t3.category_id = t5.id INNER JOIN v_employee_profile_item t6 ON t2.id = t6.employee_id AND t6.item_id = t3.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // NETO_YEAR
        self::plusSignPayrollCategory($item_id=52, $generate_mode, $period_code, $status_id, $user_id);

        // PKP
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t5.code, FLOOR((t.amount - t4.value) / 1000) * 1000 AS amount, t3.type, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN v_employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 53 INNER JOIN ptkp t4 ON t2.ptkp_id = t4.id INNER JOIN payroll_category t5 ON t3.category_id = t5.id INNER JOIN v_employee_profile_item t6 ON t2.id = t6.employee_id AND t6.item_id = t3.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // PPH21_YEAR
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t5.code, SUM(CASE WHEN t.amount > pp.batas_bawah THEN LEAST(IFNULL(pp.batas_atas, t.amount),t.amount) - pp.batas_bawah ELSE 0 END * pp.tarif) AS amount, t3.type, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN v_employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 54 INNER JOIN pph21_tarif_progresif pp INNER JOIN payroll_category t5 ON t3.category_id = t5.id INNER JOIN v_employee_profile_item t6 ON t2.id = t6.employee_id AND t6.item_id = t3.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();

        // TOTAL_POTONGAN
        self::plusPayrollCategory($item_id=36, $generate_mode, $period_code, $status_id, $user_id);

        // THP
        self::plusSignPayrollCategory($item_id=37, $generate_mode, $period_code, $status_id, $user_id);
    }

    /**
     * Basic salary
     * Fixed allowance
     * Variable alowance
    */
    public static function insertSalaryToPayroll($generate_mode, $period_code, $status_id, $user_id)
    {
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by)
            SELECT t.id AS employee_id, '$period_code' AS period_code, t3.code, t3.name, t4.code, t2.amount, t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id 
            FROM v_employee t INNER JOIN salary t2 ON t.id = t2.employee_id AND t2.status_id = 1 
            INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t2.payroll_item_id = t3.id AND t3.type = 'DATA'
            INNER JOIN payroll_category t4 ON t3.category_id = t4.id 
            INNER JOIN v_employee_profile_item t5 ON t.id = t5.employee_id AND t5.item_id = t3.id";
        \Yii::$app->db->createCommand($sql)->execute(); 
    }

    public static function sumPayrollCategory($category_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Summary by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t2.code, SUM(t.amount), t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id FROM payroll_detail t INNER JOIN payroll_category t2 ON t2.id = $category_id AND t.category_code = t2.code INNER JOIN payroll_item t3 ON t.category_code = t3.code INNER JOIN v_employee_profile_item t4 ON t.employee_id = t4.employee_id AND t4.item_id = t3.id WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function sumSignPayrollCategory($item_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Summary by Customize Category + SIGN
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t4.code, t4.name, t4.code, SUM(CASE WHEN t3.code = t4.code AND t2.sign='PLUS' THEN t.amount ELSE 0 END) - SUM(CASE WHEN t3.code = t4.code AND t2.sign='MINUS' THEN t.amount ELSE 0 END) AS amount, t4.type, t4.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN payroll_item t2 ON t.item_code = t2.code AND t2.status_id = 1 INNER JOIN payroll_category t3 ON t2.category_id = t3.id INNER JOIN payroll_item t4 ON t4.status_id = 1 AND t4.id = $item_id INNER JOIN v_employee_profile_item t5 ON t.employee_id = t5.employee_id AND t5.item_id = t4.id WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function plusPayrollCategory($item_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Plus by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t3.code, SUM(CASE WHEN FIND_IN_SET(t.item_code, t3.item_code) > 0 THEN t.amount ELSE 0 END) * t3.period_multiplier AS amount, t3.type, t3.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t 
        INNER JOIN payroll_item t3 ON t.status_id = 1 AND t3.status_id = 1 AND t3.id = $item_id 
        INNER JOIN v_employee_profile_item t5 ON t.employee_id = t5.employee_id AND t5.item_id = t3.id 
        WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function plusSignPayrollCategory($item_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Plus by Sign Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t3.code, SUM(CASE WHEN FIND_IN_SET(t.item_code, t3.item_code) > 0 AND t2.sign = 'PLUS' THEN t.amount ELSE 0 END - CASE WHEN FIND_IN_SET(t.item_code, t3.item_code) > 0 AND t2.sign = 'MINUS' THEN t.amount ELSE 0 END) AS amount, t3.type, t3.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN payroll_item t3 ON t.status_id = 1 AND t3.status_id = 1 AND t3.id = $item_id INNER JOIN payroll_item t2 ON t.item_code = t2.code INNER JOIN v_employee_profile_item t5 ON t.employee_id = t5.employee_id AND t5.item_id = t3.id WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function calculatePayrollCapParam($item_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Calculate by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, pi.code, pi.name, pc.code, ROUND(pi.percent * LEAST(t.amount, COALESCE(pi.cap, t.amount)),0) AS amount, pi.type, CONCAT('base=',t.item_code,';percent=',pi.percent,';cap=',pi.cap) AS trace, pi.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item pi ON pi.status_id = 1 AND pi.id = $item_id INNER JOIN payroll_category pc ON pi.category_id = pc.id INNER JOIN v_employee_profile_item t5 ON t.employee_id = t5.employee_id AND t5.item_id = pi.id WHERE t.period_code = '$period_code' AND t.item_code = pi.base_multiplier AND ROUND(pi.percent * LEAST(t.amount, COALESCE(pi.cap, t.amount)),0) > 0";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function calculatePayrollCapResult($item_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Calculate by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, pi.code, pi.name, pc.code, ROUND(LEAST(IFNULL(t.amount*pi.percent, 0), COALESCE(pi.cap, IFNULL(t.amount*pi.percent, 0))),0) AS amount,pi.type, CONCAT('base=',t.item_code,';percent=',pi.percent,';cap=',pi.cap) AS trace, pi.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item pi ON pi.status_id = 1 AND pi.id = $item_id INNER JOIN payroll_category pc ON pi.category_id = pc.id INNER JOIN v_employee_profile_item t5 ON t.employee_id = t5.employee_id AND t5.item_id = pi.id WHERE t.period_code = '$period_code' AND t.item_code = pi.base_multiplier AND ROUND(pi.percent * LEAST(t.amount, COALESCE(pi.cap, t.amount)),0) > 0";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function PayrollGenerateSingle($employee_id, $period_code, $status_id, $user_id)
    {
        $generate_mode = 'Single';

        $sql = "DELETE FROM payroll_detail WHERE period_code = '$period_code' AND employee_id = $employee_id AND status_id = 1";
        \Yii::$app->db->createCommand($sql)->execute();

        
    }

}
