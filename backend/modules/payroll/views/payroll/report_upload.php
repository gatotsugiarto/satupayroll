<?php
use yii\helpers\Url;
use yii\helpers\Html;



$lembur = $model->lembur ?? 0;
$reimburse = $model->reimburse ?? 0;
$absensi = $model->absensi ?? 0;
$unpaid_leave = $model->unpaid_leave ?? 0;
$keterlambatan = $model->keterlambatan ?? 0;
$thr = $model->thr ?? 0;
$no_salary = $model->no_salary ?? 0;
$join_date_prorate = $model->join_date_prorate ?? 0;
$resign_prorate = $model->resign_prorate ?? 0;

$resign = $model->resign ?? 0;




$tetap = $model->tetap ?? 0;
$stetap = $modelSyn->tetap ?? 0;
$baru = $model->baru ?? 0;
$sbaru = $modelSyn->baru ?? 0;
$pkwt = $model->pkwt ?? 0;
$spkwt = $modelSyn->pkwt ?? 0;
$karyawan = $model->karyawan ?? 0;
$skaryawan = $modelSyn->karyawan ?? 0;
?>


<div class="container-fluid">

    <?= Html::button('<i class="fa fa-upload"></i> Upload Payroll', [
            'class' => 'btn btn-primary btn-sm rounded-pill shadow-sm upload-payroll',
            'style' => 'min-width:160px;',
            'data-url' => Url::to(['upload']),
        ]) ?>

  <!-- HEADER -->
  <div class="row mb-1">
    <div class="col">
      <h4 class="mb-0">Upload Report</h4>
      <small class="text-muted">Current Period: <strong><?= date('M')?> <?= date('Y')?></strong></small>
    </div>
  </div>

  <!-- SUMMARY CARDS -->
  <div class="row">
    
    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-clock text-success icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Overtime</p>
              <h5 class="card-title"><?=$lembur?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Employee overtime records</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-money-bill-wave text-primary icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Claim</p>
              <h5 class="card-title"><?=$reimburse?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Reimbursement claims</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-hourglass-half text-warning icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Attendance (+)</p>
              <h5 class="card-title"><?=$absensi?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Adjustment entries</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-calendar-minus text-danger icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Unpaid Leave</p>
              <h5 class="card-title"><?=$unpaid_leave?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Unpaid leave records</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-user-times text-success icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Alpha</p>
              <h5 class="card-title"><?=$absensi?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Unexcused absences</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-hand-holding-usd text-primary icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Late</p>
              <h5 class="card-title"><?=$keterlambatan?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Employee lateness records</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-gift text-warning icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Bonus</p>
              <h5 class="card-title"><?=$thr?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Additional incentives</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-door-open text-danger icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Prorate Join Date</p>
              <h5 class="card-title"><?=$join_date_prorate?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Adjustment new joiners</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-sign-out-alt text-warning icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">Prorate Resign</p>
              <h5 class="card-title"><?=$resign_prorate?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Adjustment for resigning</div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card card-stats">
        <div class="card-body">
          <div class="row">
            <div class="col-4 text-center">
              <i class="fas fa-file-alt text-danger icon-big"></i>
            </div>
            <div class="col-8">
              <p class="card-category text-muted-small">No Salary</p>
              <h5 class="card-title"><?=round($no_salary)?></h5>
            </div>
          </div>
        </div>
        <div class="card-footer text-muted-small">Without salary components</div>
      </div>
    </div>
  
  </div>



  <!-- COMPARISON TABLE -->
  <div class="row mt-4">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h6 class="mb-0">Upload Comparison</h6>
          <p class="text-muted-small mb-0">Data Upload vs Existing</p>
        </div>
        <div class="card-body">
          <div class="creative-table-wrapper">
            <table class="creative-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Uploaded</th>
                        <th>Database</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Join Employee</td>
                        <td><?=$baru?></td>
                        <td><?=$sbaru?></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>Employee Permanent</td>
                        <td><?=$tetap?></td>
                        <td><?=$stetap?></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>Employee - PKWT</td>
                        <td><?=$pkwt?></td>
                        <td><?=$spkwt?></td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>Total Employees</td>
                        <td><?=$karyawan?></td>
                        <td><?=$skaryawan?></td>
                      </tr>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- APP MODAL -->
<div class="modal fade" id="appModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-body p-4"></div>
        </div>
    </div>
</div>


<?php
// ====================== JAVASCRIPT ======================
$this->registerJs(<<<JS
// Upload EDIT MODAL
$(document).on('click', '.upload-payroll', function() {
    $('#appModal .modal-body').html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin fa-2x text-muted"></i></div>');
    $('#appModal').modal('show').find('.modal-body').load($(this).data('url'));
});

// VIEW MODAL
$(document).on('click', '.view-company', function() {
    $('#viewModal').modal('show').find('.modal-body').load($(this).data('url'));
});

JS);
?>