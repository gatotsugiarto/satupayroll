<?php

namespace backend\modules\payroll\controllers;

use Yii;

use common\modules\payroll\models\PayrollThr;
use common\modules\payroll\models\PayrollThrSearch;
use common\modules\payroll\models\PayrollDetailThr;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use Mpdf\Mpdf;

/**
 * PayrollthrController implements the CRUD actions for PayrollThr model.
 */
class PayrollthrController extends Controller
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

    /**
     * Lists all PayrollThr models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PayrollThrSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PayrollThr model.
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
        $model = new PayrollThr();
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
                        'message' => 'THR processing has been completed successfully. All employee payroll data has been finalized and recorded.',
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
            Yii::$app->session->setFlash('success', 'THR processing has been completed successfully. All employee payroll data has been finalized and recorded.');
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
        $model = new PayrollThr();
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
                        'message' => "The THR period $period_code has been reviewed and approved by the Finance department and is now finalized.",
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
            Yii::$app->session->setFlash('success', "The THR period $period_code has been reviewed and approved by the Finance department and is now finalized.");
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_approve', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    public function actionCancel()
    {
        $model = new PayrollThr();
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
                        'message' => 'THR processing has been cancelled successfully. All payroll data for the selected period has been stopped and will not be processed further.',
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
            Yii::$app->session->setFlash('success', 'THR processing has been cancelled successfully. All payroll data for the selected period has been stopped and will not be processed further.');
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_cancel', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    /**
     * Creates a new PayrollThr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new PayrollThr();
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
                        'message' => 'THR processing has been successfully revised. All payroll data for the selected period has been updated and reprocessed accordingly.',
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
            Yii::$app->session->setFlash('success', 'THR processing has been successfully revised. All payroll data for the selected period has been updated and reprocessed accordingly.');
            return $this->redirect(['index']);
            
        }

        $formToken = $model->getBehavior('tokenProtection')->generateToken();
        return $this->render('_form', [
            'model'     => $model,
            'formToken' => $formToken,
        ]);
    }

    /**
     * Updates an existing PayrollThr model.
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
     * Deletes an existing PayrollThr model.
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

    /**
     * Finds the PayrollThr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PayrollThr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PayrollThr::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
