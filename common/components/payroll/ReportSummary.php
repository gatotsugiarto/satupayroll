<?php
namespace common\components\payroll;

use yii\base\Component;

use Yii;
use yii\db\Query; 
use yii\db\Expression;


class ReportSummary extends Component
{
    public static function BatchL1($year, $month, $period_code, $status_id, $user_id)
    {
        if($month == 12){
            $tax_info = 'PROGRESIF';
        }else{
            $tax_info = 'TER';
        }

        /*
        DELETE
        */
        $sql = "DELETE FROM payroll_detail_l3 WHERE period_code = '$period_code' AND status_id = 1";
        \Yii::$app->db->createCommand($sql)->execute();

        $sql = "SELECT id, payroll_mode FROM payroll_profile"; 
        $results = Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($results as $rows) {
            $payroll_mode = $rows['payroll_mode'];
            $payroll_mode_id = $rows['id'];

            $query = (new Query())
            ->select(new Expression("GROUP_CONCAT(LOWER(item_code) ORDER BY display_order ASC SEPARATOR ', ') AS fields"))
            ->from('m_summary_payroll_item')
            ->where([
                'tax_info' => $tax_info, 
                'payroll_mode_id' => $payroll_mode_id,
            ])->one();
            $fields = $query['fields']; 

            $sql = " SELECT GROUP_CONCAT( CONCAT( 'IFNULL(MAX(CASE WHEN pd.item_code = ''', spi.item_code, ''' THEN pd.', spi.field_info, ' END),0) AS ', spi.item_code ) SEPARATOR ', ' ) AS dynamic_select FROM m_summary_payroll_item spi WHERE spi.tax_info = '$tax_info' AND spi.payroll_mode_id = $payroll_mode_id";
            $dynamic_select = Yii::$app->db->createCommand($sql)->queryScalar();

            if($fields && $dynamic_select){
                $sql = "INSERT INTO payroll_detail_l3 (employee_id, period_code, payroll_mode, generate_mode, $fields, status_id, created_at, created_by, updated_at, updated_by) SELECT pd.employee_id, pd.period_code, pp.payroll_mode, pd.generate_mode, $dynamic_select, $status_id, NOW(), $user_id, NOW(), $user_id FROM payroll_detail pd INNER JOIN payroll_profile pp ON pd.profile_id = pp.id WHERE pd.period_code = '$period_code' AND pp.id = $payroll_mode_id GROUP BY pd.employee_id";
                \Yii::$app->db->createCommand($sql)->execute();
            }
            
        }
    }
}
