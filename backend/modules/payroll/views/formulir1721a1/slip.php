<?php
use yii\helpers\Html;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Formulir 1721-A1 - Bukti Potong PPh 21</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    td, th { border: 1px solid #000; padding: 8px; }
    .section-title { background: #f0f0f0; font-weight: bold; }
  </style>
</head>
<body>
  <h2>BUKTI POTONG PAJAK PENGHASILAN PASAL 21<br>(Formulir 1721-A1)</h2>

  <table>
    <tr><td class="section-title" colspan="2">I. Identitas Pemberi Kerja</td></tr>
    <tr><td width="30%">Nama Perusahaan</td><td><?= $model->nama_perusahaan ?></td></tr>
    <tr><td>NPWP</td><td><?= $model->npwp_perusahaan ?></td></tr>
    <tr><td>Alamat</td><td><?= $model->alamat_perusahaan ?></td></tr>
  </table>

  <table>
    <tr><td class="section-title" colspan="2">II. Identitas Penerima Penghasilan</td></tr>
    <tr><td width="30%">Nama</td><td><?= $model->nama_pegawai ?></td></tr>
    <tr><td>NPWP/NIK</td><td><?= $model->npwp_nik_pegawai ?></td></tr>
    <tr><td>Status PTKP</td><td><?= $model->status_ptkp ?></td></tr>
    <tr><td>Alamat</td><td><?= $model->alamat_pegawai ?></td></tr>
  </table>

  <table>
    <tr><td class="section-title" colspan="2">III. Rincian Penghasilan dan Potongan</td></tr>
    <tr><td>Penghasilan Bruto Setahun</td><td>Rp <?= number_format($model->penghasilan_bruto, 0, ',', '.') ?></td></tr>
    <tr><td>Biaya Jabatan</td><td>Rp <?= number_format($model->biaya_jabatan, 0, ',', '.') ?></td></tr>
    <tr><td>Iuran Pensiun/JHT</td><td>Rp <?= number_format($model->iuran_pensiun_jht, 0, ',', '.') ?></td></tr>
    <tr><td>Penghasilan Neto</td><td>Rp <?= number_format($model->penghasilan_neto, 0, ',', '.') ?></td></tr>
    <tr><td>Penghasilan Kena Pajak (PKP)</td><td>Rp <?= number_format($model->pkp, 0, ',', '.') ?></td></tr>
    <tr><td>PPh 21 Terutang</td><td>Rp <?= number_format($model->pph21_terutang, 0, ',', '.') ?></td></tr>
    <tr><td>PPh 21 Dipotong Perusahaan</td><td>Rp <?= number_format($model->pph21_dipotong_perusahaan, 0, ',', '.') ?></td></tr>
  </table>

  <table>
    <tr><td class="section-title" colspan="2">IV. Tanda Tangan</td></tr>
    <tr><td>Tanggal Bukti Potong</td><td><?= date('d-M-Y', strtotime($model->created_at)) ?></td></tr>
    <tr><td>Nama Pejabat</td><td><?= $model->nama_pejabat ?></td></tr>
    <tr>
      <td>Tanda Tangan & Stempel</td>
      <td>
        <?php
        if($model->sign_image){   
            $photos=explode('**',trim($model->sign_image));
            foreach($photos as $image){
                if($image) {
                  ?>
                    <img src="<?= Yii::getAlias('@webroot/img/attachment/'.$image) ?>" width="137" height="80">
                <?php
                }
            }
        }
        ?>
        <br />
        (   <?= $model->sign_name ?>   )
      </td>
    </tr>
  </table>
</body>
</html>
