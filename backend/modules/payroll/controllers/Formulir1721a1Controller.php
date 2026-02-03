<?php

namespace backend\modules\payroll\controllers;

use Yii;

use common\modules\payroll\models\Formulir1721A1;
use common\modules\payroll\models\Formulir1721A1Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Mpdf\Mpdf;

/**
 * Formulir1721a1Controller implements the CRUD actions for Formulir1721A1 model.
 */
class Formulir1721a1Controller extends Controller
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
     * Lists all Formulir1721A1 models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new Formulir1721A1Search();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Formulir1721A1 model.
     * @param string $id ID
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

    /**
     * Creates a new Formulir1721A1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Formulir1721A1();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Formulir1721A1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id ID
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
     * Deletes an existing Formulir1721A1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id ID
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

        // // Render partial 
        // return $this->renderPartial('slip', [
        //     'model' => $model,
        // ]);
        
        
        // PDF
        $html = $this->renderPartial('slip', [
            'model' => $model,
        ]);

        $mpdf = new Mpdf([
            'orientation' => 'L' // 'L' untuk landscape, 'P' untuk portrait (default)
        ]);

        // // 🔐 Password PDF
        // // if($action){
        //     $mpdf->SetProtection(
        //         ['print'],   // boleh print saja
        //         '1234567',      // password buka PDF
        //         '1234567'       // password owner
        //     );
        // // }

        // Output PDF ke browser
        $mpdf->WriteHTML($html);
        $filename = 'BUKTI_POTONG_PAJAK_PENGHASILAN_'.$model->tahun_pajak.'_'.$model->employee->fullname.'_'.$model->employee->e_number.'.pdf';
        return $mpdf->Output($filename, 'D');    
    }

    /**
     * Finds the Formulir1721A1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id ID
     * @return Formulir1721A1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Formulir1721A1::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
