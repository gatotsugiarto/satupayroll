<?php

namespace backend\modules\payroll\controllers;

use Yii;

use common\modules\payroll\models\Payroll;
use common\modules\payroll\models\PayrollSearch;
use common\modules\payroll\models\PayrollDetail;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use Mpdf\Mpdf;

use common\modules\master\models\UploadForm;
use common\modules\payroll\models\EmployeeUpload;
use common\modules\payroll\models\ReportUpload;
use common\modules\payroll\models\EmployeeHistory;
use common\modules\payroll\models\EmployeeJoinResignSearch;

/**
 * PayrollController implements the CRUD actions for Payroll model.
 */
class PayrollController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionUpload()
    {
        $model = new UploadForm();
        $modelPayroll = new Payroll();

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_upload', [
                'model'     => $model,
            ]);
        }

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->validate()) {
                $inputFile = $model->file->tempName;

                $exists = Payroll::find()->where(['status_id' => 1])->limit(1)->exists();
                if ($exists) {
                    Yii::$app->session->setFlash('warning', 'Upload failed, there payroll is awaiting Finance approval and cannot be processed while its status is Draft.');
                }else{
                
                    $referral_code = 'UPL'.date('Ymdhis');
                    $result = EmployeeUpload::saveRecords($inputFile, $referral_code);

                    if($result === true){
                        EmployeeHistory::create($referral_code, "Import Payroll", "Import data payroll telah berhasil [$referral_code]");
                        // return false;
                        Yii::$app->session->setFlash('success', 'Import data payroll telah berhasil');
                        return $this->redirect(['reportupload', 'referral_code' => $referral_code]);
                    }else{
                        Yii::$app->session->setFlash('error', 'Terjadi kesalahan: ' . $e->getMessage());
                    }
                }
            }
        }

        return $this->render('_upload', [
            'model'     => $model,
        ]);
    }

    public function actionReportupload($referral_code=0)
    {
        $model = ReportUpload::findOne(1);
        $modelSyn = ReportUpload::findOne(2);

        return $this->render('report_upload', [
            'model' => $model,
            'modelSyn' => $modelSyn,
        ]);
    }

    public function actionJoinresign()
    {
        $searchModel = new EmployeeJoinResignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('joinresign', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRunall()
    {
        $model = new Payroll();

        $model->year = 2025;
        
        $model->month = 1;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 2;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 3;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 4;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 5;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 6;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 7;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 8;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 9;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 10;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 11;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);

        $model->month = 12;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);
    }

    public function actionRun()
    {
        $model = new Payroll();

        $model->year = 2025;
        
        $model->month = 1;
        $generate_mode = 'Batch';
        $model->PayrollGenerate($generate_mode);
    }

    /**
     * Lists all Payroll models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PayrollSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payroll model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', ['model' => $model]);
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionBatch()
    {
        $model = new Payroll();
        $model->scenario = 'create';

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                if ($model->validate()) {
                    $model->getBehavior('tokenProtection')->consumeToken();

                    $generate_mode = 'Batch';
                    $model->PayrollGenerate($generate_mode);

                    return [
                        'success' => true,
                        'message' => 'Payroll processing has been completed successfully. All employee payroll data has been finalized and recorded.',
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => ActiveForm::validate($model),
                ];
            }

            $formToken = $model->getBehavior('tokenProtection')->generateToken();
            return $this->renderAjax('_batch', [
                'model'     => $model,
                'formToken' => $formToken,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $generate_mode = 'Batch';
            $model->PayrollGenerate($generate_mode);
            
            $model->getBehavior('tokenProtection')->consumeToken();
            Yii::$app->session->setFlash('success', 'Payroll processing has been completed successfully. All employee payroll data has been finalized and recorded.');
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_batch', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    public function actionApprove()
    {
        $model = new Payroll();
        $model->scenario = 'approve';

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                if ($model->validate()) {
                    $period_code = $model->year . '-' . str_pad($model->month, 2, '0', STR_PAD_LEFT);
                    $generate_mode = 'Batch';
                    $model->PayrollApprove($generate_mode);
                    $model->getBehavior('tokenProtection')->consumeToken();

                    return [
                        'success' => true,
                        'message' => "The payroll period $period_code has been reviewed and approved by the Finance department and is now finalized.",
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => ActiveForm::validate($model),
                ];
            }

            $formToken = $model->getBehavior('tokenProtection')->generateToken();
            return $this->renderAjax('_approve', [
                'model'     => $model,
                'formToken' => $formToken,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $generate_mode = 'Batch';
            $model->PayrollApprove($generate_mode);
            $period_code = $model->year . '-' . str_pad($model->month, 2, '0', STR_PAD_LEFT);
            
            $model->getBehavior('tokenProtection')->consumeToken();
            Yii::$app->session->setFlash('success', "The payroll period $period_code has been reviewed and approved by the Finance department and is now finalized.");
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_approve', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    public function actionCreate()
    {
        $model = new Payroll();
        $model->scenario = 'single';

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                if ($model->validate()) {
                    $model->getBehavior('tokenProtection')->consumeToken();

                    $generate_mode = 'Single';
                    $model->PayrollGenerate($generate_mode, $model->arr_employee_id);

                    return [
                        'success' => true,
                        'message' => 'Payroll processing has been successfully revised. All payroll data for the selected period has been updated and reprocessed accordingly.',
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => ActiveForm::validate($model),
                ];
            }

            $formToken = $model->getBehavior('tokenProtection')->generateToken();
            return $this->renderAjax('_form', [
                'model'     => $model,
                'formToken' => $formToken,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $generate_mode = 'Single';
            $model->PayrollGenerate($generate_mode, $model->arr_employee_id);
            
            $model->getBehavior('tokenProtection')->consumeToken();
            Yii::$app->session->setFlash('success', 'Payroll processing has been successfully revised. All payroll data for the selected period has been updated and reprocessed accordingly.');
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_form', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    public function actionCancel()
    {
        $model = new Payroll();
        $model->scenario = 'cancel';

        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                if ($model->validate()) {
                    $model->getBehavior('tokenProtection')->consumeToken();

                    $generate_mode = 'Batch';
                    $model->PayrollCancel($generate_mode);

                    return [
                        'success' => true,
                        'message' => 'Payroll processing has been cancelled successfully. All payroll data for the selected period has been stopped and will not be processed further.',
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => ActiveForm::validate($model),
                ];
            }

            $formToken = $model->getBehavior('tokenProtection')->generateToken();
            return $this->renderAjax('_cancel', [
                'model'     => $model,
                'formToken' => $formToken,
            ]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $generate_mode = 'Batch';
            $model->PayrollCancel($generate_mode);
            
            $model->getBehavior('tokenProtection')->consumeToken();
            Yii::$app->session->setFlash('success', 'Payroll processing has been cancelled successfully. All payroll data for the selected period has been stopped and will not be processed further.');
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_cancel', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    /**
     * Updates an existing Payroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payroll model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSlip($id=0)
    {
        $model = $this->findModel($id);
        // $detailC = PayrollDetail::find()
        // ->where([
        //     'employee_id' => $model->employee_id, 
        //     'period_code' => $model->period_code,
        //     'slip_display' => 'Y',
        //     'slip_position' => 'C',
        // ])
        // ->orderBy(['display_order' => SORT_ASC])
        // ->all();

        $query = (new \yii\db\Query())
            ->select([
                'pi.name AS item_name',
                'IFNULL(pd.amount, 0) AS amount',
            ])
            ->from('payroll_item pi')
            ->leftJoin(
                'payroll_detail pd',
                'pi.code = pd.item_code 
                 AND pd.employee_id = :employeeId 
                 AND pd.period_code = :periodCode',
                [':employeeId' => $model->employee_id, ':periodCode' => $model->period_code]
            )
            ->where([
                'pi.slip_display' => 'Y',
                'pi.slip_position' => 'C',
            ])
            ->andWhere('(pi.monthly_exec <> 12 OR pi.monthly_exec = RIGHT(pd.period_code,2))')
            ->orderBy(['pi.display_order' => SORT_ASC]);
        $detailC = $query->all();



        // $detailD = PayrollDetail::find()
        // ->where([
        //     'employee_id' => $model->employee_id, 
        //     'period_code' => $model->period_code,
        //     'slip_display' => 'Y',
        //     'slip_position' => 'D',
        // ])
        // ->orderBy(['display_order' => SORT_ASC])
        // ->all();

        $query = (new \yii\db\Query())
            ->select([
                'pi.name AS item_name',
                'IFNULL(pd.amount, 0) AS amount',
            ])
            ->from('payroll_item pi')
            ->leftJoin(
                'payroll_detail pd',
                'pi.code = pd.item_code 
                 AND pd.employee_id = :employeeId 
                 AND pd.period_code = :periodCode',
                [':employeeId' => $model->employee_id, ':periodCode' => $model->period_code]
            )
            ->where([
                'pi.slip_display' => 'Y',
                'pi.slip_position' => 'D',
            ])
            ->andWhere('(pi.monthly_exec <> 12 OR pi.monthly_exec = RIGHT(pd.period_code,2))')
            ->orderBy(['pi.display_order' => SORT_ASC]);
        $detailD = $query->all();

        // // Render partial 
        // return $this->renderPartial('slip', [
        //     'model' => $model,
        //     'detailC' => $detailC,
        //     'detailD' => $detailD,
        // ]);
        
        
        // PDF
        $html = $this->renderPartial('slip', [
            'model' => $model,
            'detailC' => $detailC,
            'detailD' => $detailD,
        ]);

        $mpdf = new Mpdf([
            'orientation' => 'L' // 'L' untuk landscape, 'P' untuk portrait (default)
        ]);

        // 🔐 Password PDF
        // if($action){
            $mpdf->SetProtection(
                ['print'],   // boleh print saja
                '1234567',      // password buka PDF
                '1234567'       // password owner
            );
        // }

        // Output PDF ke browser
        $mpdf->WriteHTML($html);
        $filename = 'Slip_Gaji_'.$model->rmonth->month.'_'.$model->year.'_'.str_replace('.', '', $model->employee->e_number).'.pdf';
        return $mpdf->Output($filename, 'D');    
    }

    /**
     * Finds the Payroll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Payroll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payroll::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
