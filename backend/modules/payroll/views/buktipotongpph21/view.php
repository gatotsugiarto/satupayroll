<?php
use yii\helpers\Html;
?>

<div class="mb-3">
    <h5 class="text-primary fw-bold page-title">
        <i class="fa fa-building"></i>&nbsp;&nbsp;&nbsp;Detail Bukti Potong Pph21
    </h5>
    <p class="text-muted small mb-0">
        Bukti Resmi Pemotongan PPh Pasal 21
    </p>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Masa Pajak</span><br>
                <span class="fw-semibold"><small>Code: <?= Html::encode($model->masa_pajak) ?></small></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Tahun Pajak</span><br>
                <span class="fw-semibold"><?= Html::encode($model->tahun_pajak) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">NPWP Perusahaan</span><br>
                <span class="fw-semibold"><?= Html::encode($model->npwp_perusahaan) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Nama Perusahaan</span><br>
                <span class="fw-semibold"><?= Html::encode($model->nama_perusahaan) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">NPWP/ NIK Pegawai</span><br>
                <span class="fw-semibold"><?= Html::encode($model->npwp_nik_pegawai) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Nama Pegawai</span><br>
                <span class="fw-semibold"><?= Html::encode($model->nama_pegawai) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Status Pegawai</span><br>
                <span class="fw-semibold"><?= Html::encode($model->status_pegawai) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Kode Objek Pajak</span><br>
                <span class="fw-semibold"><?= Html::encode($model->kode_objek_pajak) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Status PTKP</span><br>
                <span class="fw-semibold"><?= Html::encode($model->status_ptkp) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Penghasilan Bruto</span><br>
                <span class="fw-semibold"><?= Html::encode($model->penghasilan_bruto) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Biaya Jabatan</span><br>
                <span class="fw-semibold"><?= Html::encode($model->biaya_jabatan ) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">Iuran Pensiun/JHT</span><br>
                <span class="fw-semibold"><?= Html::encode($model->iuran_pensiun_jht ) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Penghasilan Neto</span><br>
                <span class="fw-semibold"><?= Html::encode($model->penghasilan_neto) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">PPh21 Terutang</span><br>
                <span class="fw-semibold"><?= Html::encode($model->pph21_terutang) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">PPh21 Dipotong Karyawan</span><br>
                <span class="fw-semibold"><?= Html::encode($model->pph21_dipotong_karyawan) ?></span>
            </div>
            <div class="col-md-6">
                <span class="text-secondary small">PPh21 Ditanggung Perusahaan</span><br>
                <span class="fw-semibold"><?= Html::encode($model->pph21_ditanggung_perusahaan) ?></span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <span class="text-secondary small">Skema Pajak</span><br>
                <span class="fw-semibold"><?= Html::encode($model->skema_pajak) ?></span>
            </div>
            <div class="col-md-6"></div>
        </div>
        
        <hr class="my-2">

        <div class="row mb-2 small">
            <div class="col-md-6 text-muted">
                <i class="fa fa-plus-circle"></i> Created by:
                <strong><?= Html::encode($model->createdBy->fullname) ?></strong>
                <br>
                <i class="far fa-clock"></i> <small><?= Html::encode($model->created_at) ?></small>
            </div>
            <div class="col-md-6 text-muted">
                <i class="fa fa-edit"></i> Updated by:
                <strong><?= Html::encode($model->updatedBy->fullname) ?></strong>
                <br>
                <i class="far fa-clock"></i> <small><?= Html::encode($model->updated_at) ?></small>
            </div>
        </div>

        

    </div>
</div>

<div class="text-end mt-3">
    <?= Html::button('<i class="fa fa-times"></i> Close', [
        'class' => 'btn btn-outline-secondary',
        'data-dismiss' => 'modal',
        'style' => 'min-width:140px;',
    ]) ?>
</div>
