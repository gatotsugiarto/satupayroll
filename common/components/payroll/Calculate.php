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
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by)
            SELECT t.id AS employee_id, '$period_code' AS period_code, t3.code, t3.name, t4.code, t2.amount, t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id 
            FROM employee t INNER JOIN salary t2 ON t.id = t2.employee_id AND t.status_id = 1 AND t2.status_id = 1 
            INNER JOIN payroll_item t3 ON t3.status_id = 1 AND t2.payroll_item_id = t3.id AND t3.type = 'DATA'
            INNER JOIN payroll_category t4 ON t3.category_id = t4.id 
            AND NOT EXISTS (SELECT 1 FROM employee_pending ep WHERE ep.employee_id = t.id AND ep.status_id = 1) AND EXISTS (SELECT 1 FROM salary s WHERE s.employee_id = t.id AND s.payroll_item_id = 1 AND s.status_id = 1)";
        \Yii::$app->db->createCommand($sql)->execute();

        // INCOME_FIXED
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t2.code, SUM(t.amount), t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id FROM payroll_detail t INNER JOIN payroll_category t2 ON t2.display_order = 1 AND t.category_code = t2.code INNER JOIN payroll_item t3 ON t.category_code = t3.code WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();

        // INCOME_VAR
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t2.code, SUM(t.amount), t3.type, t3.display_order, '$generate_mode', $status_id, NOW(), $user_id, NOW(), $user_id FROM payroll_detail t INNER JOIN payroll_category t2 ON t2.display_order = 2 AND t.category_code = t2.code INNER JOIN payroll_item t3 ON t.category_code = t3.code WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();

        // GAJI_ACTUAL
        $sql = "INSERT INTO payroll_detail (employee_id, period_code, item_code, item_name, category_code, amount, source, display_order, generate_mode, status_id, created_at, created_by, updated_at, updated_by) SELECT t.employee_id, '$period_code' AS period_code, t3.code, t3.name, t2.code, SUM(CASE WHEN FIND_IN_SET(t.item_code, t2.item_code) > 0 THEN t.amount ELSE 0 END) AS amount, t3.type, t3.display_order, '$generate_mode', 1, NOW(), 1, NOW(), 1 FROM payroll_detail t INNER JOIN payroll_category t2 ON t2.display_order = 3 INNER JOIN payroll_item t3 ON t2.code = t3.code WHERE t.period_code = '$period_code' GROUP BY t.employee_id";
        \Yii::$app->db->createCommand($sql)->execute();
    }

    public static function PayrollGenerateSingle($employee_id, $period_code, $status_id, $user_id)
    {
        $generate_mode = 'Single';

        $sql = "DELETE FROM payroll_detail WHERE period_code = '$period_code' AND employee_id = $employee_id AND status_id = 1";
        \Yii::$app->db->createCommand($sql)->execute();

        
    }

}
