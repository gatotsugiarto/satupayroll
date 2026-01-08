<?php
namespace common\components\payroll;

use yii\base\Component;


class Calculate extends Component
{
    public static function PayrollGenerateBatch($period_code, $status_id, $user_id)
    {
        /*
        1. DATA
        2. INCOME_FIXED dan INCOME_VAR Pola Sama
        3. GAJI_ACTUAL
         */
        $generate_mode = 'Batch';

        $sql = "DELETE FROM payroll_detail WHERE period_code = '$period_code' AND status_id = 1";
        \Yii::$app->db->createCommand($sql)->execute();

        // DATA
        self::insertSalaryToPayroll($generate_mode, $period_code, $status_id, $user_id);

        // INCOME_FIXED
        self::sumPayrollCategory($category_id=1, $generate_mode, $period_code, $status_id, $user_id);

        // INCOME_VAR
        self::sumPayrollCategory($category_id=2, $generate_mode, $period_code, $status_id, $user_id);

        // OTHER_INCOME
        self::sumSignPayrollCategory($category_id=46, $generate_mode, $period_code, $status_id, $user_id);

        // GAJI_ACTUAL
        self::plusPayrollCategory($category_id=11, $generate_mode, $period_code, $status_id, $user_id);
        
        // EMPLOYER_BPJS -> JKM, JP_PERUSAHAAN, JHT_PERUSAHAAN, BPJS_KES_PERUSAHAAN
        self::calculatePayrollCategory($category_id=3, $generate_mode, $period_code, $status_id, $user_id);

        // EMPLOYEE_BPJS -> JHT_KARY, JP_KARY, BPJS_KES_KARY
        self::calculatePayrollCategory($category_id=5, $generate_mode, $period_code, $status_id, $user_id);

        // JKK -> Relate other table
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t3.code, ROUND(t4.amount * t.amount,0) AS amount, t3.type, CONCAT('base=',t.item_code,';percent=',t3.percent,';cap=',t3.cap) AS trace, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 15 INNER JOIN jkk t4 ON t2.jkk_id = t4.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // EMPLOYER_BPJS
        self::plusPayrollCategory($category_id=47, $generate_mode, $period_code, $status_id, $user_id);

        // EMPLOYEE_BPJS
        self::plusPayrollCategory($category_id=48, $generate_mode, $period_code, $status_id, $user_id);

        // GROSS
        self::plusPayrollCategory($category_id=26, $generate_mode, $period_code, $status_id, $user_id);

        // TOTAL_BEBAN_PERUSAHAAN
        self::plusPayrollCategory($category_id=27, $generate_mode, $period_code, $status_id, $user_id);

        // GROSS_TAX
        self::plusPayrollCategory($category_id=28, $generate_mode, $period_code, $status_id, $user_id);

        // Ter  -> TER Category
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, description, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.id, '$period_code' AS period_code, t4.code, t4.name, t4.code, t3.ter, t4.type, NULL, t4.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM employee t INNER JOIN ptkp t2 ON t2.id = t.ptkp_id INNER JOIN ter t3 ON t3.id = t2.ter_id INNER JOIN payroll_item t4 ON t4.status_id = 1 AND t4.id = 29";
        \Yii::$app->db->createCommand($sql)->execute();

        // TER_RATE
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t3.code, t4.ter AS amount, t3.type, CONCAT('base=',t.item_code,';percent=',t3.percent,';cap=',t3.cap) AS trace, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 30 INNER JOIN ter_prosen t4 ON t2.ptkp_id = t4.ptkp_id AND t.amount BETWEEN t4.bruto_from AND t4.bruto_to WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // PPH21_GROSS
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t3.code, t3.name, t5.code, ROUND((t4.ter * t.amount),0) AS amount, t3.type, CONCAT('base=',t.item_code,';percent=',t3.percent,';cap=',t3.cap) AS trace, t3.display_order, 'Batch', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN employee t2 ON t2.id = t.employee_id INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t3.id = 31 INNER JOIN ter_prosen t4 ON t2.ptkp_id = t4.ptkp_id AND t.amount BETWEEN t4.bruto_from AND t4.bruto_to INNER JOIN payroll_category t5 ON t3.category_id = t5.id WHERE t.period_code = '$period_code' AND t.item_code = t3.base_multiplier";
        \Yii::$app->db->createCommand($sql)->execute();

        // TOTAL_POTONGAN
        self::plusPayrollCategory($category_id=36, $generate_mode, $period_code, $status_id, $user_id);

        // THP
        self::sumSignPayrollCategory($category_id=37, $generate_mode, $period_code, $status_id, $user_id);
    }

    public static function insertSalaryToPayroll($generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Basic salary
         * Fixed allowance
         * Variable alowance
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by)
            SELECT t.id AS employee_id, '$period_code' AS period_code, t3.code, t3.name, t4.code, t2.amount, t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id 
            FROM employee t INNER JOIN salary t2 ON t.id = t2.employee_id AND t.status_id = 1 AND t2.status_id = 1 
            INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t2.payroll_item_id = t3.id AND t3.type = 'DATA'
            INNER JOIN payroll_category t4 ON t3.category_id = t4.id 
            AND NOT EXISTS (SELECT 1 FROM employee_pending ep WHERE ep.employee_id = t.id AND ep.status_id = 1) AND EXISTS (SELECT 1 FROM salary s WHERE s.employee_id = t.id AND s.payroll_item_id = 1 AND s.status_id = 1)";
        \Yii::$app->db->createCommand($sql)->execute(); 
    }

    public static function sumPayrollCategory($category_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Summary by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t2.code, SUM(t.amount), t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id FROM payroll_detail t INNER JOIN payroll_category t2 ON t2.id = $category_id AND t.category_code = t2.code INNER JOIN payroll_item t3 ON t.category_code = t3.code WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function sumSignPayrollCategory($category_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Summary by Customize Category + SIGN
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t4.code, t4.name, t4.code, SUM(CASE WHEN t3.code = t4.code AND t2.sign='PLUS' THEN t.amount ELSE 0 END) - SUM(CASE WHEN t3.code = t4.code AND t2.sign='MINUS' THEN t.amount ELSE 0 END) AS amount, t4.type, t4.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN payroll_item t2 ON t.item_code = t2.code AND t2.status_id = 1 INNER JOIN payroll_category t3 ON t2.category_id = t3.id INNER JOIN payroll_item t4 ON t4.status_id = 1 AND t4.id = $category_id WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function plusPayrollCategory($category_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Plus by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t3.code, SUM(CASE WHEN FIND_IN_SET(t.item_code, t3.item_code) > 0 THEN t.amount ELSE 0 END) AS amount, t3.type, t3.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN payroll_item t3 ON t.status_id = 1 AND t3.status_id = 1 AND t3.id = $category_id WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function calculatePayrollCategory($category_id, $generate_mode, $period_code, $status_id, $user_id)
    {
        /**
         * Calculate by Category
        */
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, trace, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t2.id, '$period_code' AS period_code, t4.code, t4.name, t3.code, ROUND(t4.percent * LEAST(t.amount, COALESCE(t4.cap, t.amount)),0) AS amount, t4.type, CONCAT('base=',t.item_code,';percent=',t4.percent,';cap=',t4.cap) AS trace, t4.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN employee t2 ON t2.id = t.employee_id INNER JOIN payroll_category t3 ON t3.id = $category_id INNER JOIN payroll_item t4 ON t4.status_id = 1 AND t4.category_id = t3.id WHERE t.period_code = '$period_code' AND t.item_code = t4.base_multiplier AND ROUND(t4.percent * LEAST(t.amount, COALESCE(t4.cap, t.amount)),0) > 0";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function PayrollGenerateSingle($employee_id, $period_code, $status_id, $user_id)
    {
        $generate_mode = 'Single';

        $sql = "DELETE FROM payroll_detail WHERE period_code = '$period_code' AND employee_id = $employee_id AND status_id = 1";
        \Yii::$app->db->createCommand($sql)->execute();

        
    }

}
