<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Karyawan</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>
<style>
    /* General Styles */
    body {
        font-family: 'Courier New', Courier, monospace;
        width: 80%;
        margin: 0 auto;
        padding: 1px 5px 1px 5px;
        background-color: white;
    }

    .confidential {
        text-align: right; 
        font-weight: bold; 
        font-style: italic;
    }

    /*.company-info {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: white;
    }

    .logo {
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .logo img {
        width: 40px;
        height: auto;
    }

    .company-details {
        text-align: left;
        font-weight: bold;
    }

    .company-name {
        font-size: 16px;
        margin-bottom: 1px;
    }

    .company-address {
        font-size: 12px;
    }*/

    .company {
        text-align: center;
        width: 100%; 
        font-weight: bold; 
/*        margin-bottom: 1px;*/
    }
    .company .logo{
        text-align: right;
        padding-right: 10px;
        height: auto;
    }

    .company .company_info{
        text-align: left;
    }

    .company .company_name{
        font-size: 16px;
        /*border-collapse: collapse; 
        margin-bottom: 20px;*/
    }
    .company .company_address{
        font-size: 12px;
        margin-bottom: 20px;
    }

    .header {
        width: 100%; 
        border-collapse: collapse; 
        margin-bottom: 20px;
    }
    .header tr td {
        font-size: 12px;
        color: #555;
    }

    .content {
        width: 100%; 
        border-collapse: collapse;
    }
    .content .pendapatan {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        color: #555;
    }
    .content .pendapatan th {
        padding: 8px; 
        background-color: #FFC107;
        font-size: 14px;
    }
    .content .left_label {
        padding: 3px 0 0 8px;
        font-size: 11px;
        font-weight: bold;
        color: #555;
    }
    .content .right_label {
        padding: 0 0 0 17px;
        font-size: 11px;
        font-weight: bold;
        color: #555;
    }
    .content .left_amount {
        padding: 0 20px 0 0;
        text-align: right;
        font-size: 12px;
        color: #555;
    }
    .content .right_amount {
        padding: 3px 20px 0 0;
        text-align: right;
        font-size: 12px;
        color: #555;
    }

    .content .footer {
        background-color: #D7D6D6; 
        font-weight: bold;border-top: 1px solid black;
        border-bottom: 1px solid black;
        font-size: 14px;
        color: #555;
    }

    .total {
        width: 100%; margin-top: 20px;
        font-size: 14px;
        color: #555;
    }

</style>

<?php
// function lastmonth($tahun, $bulan){
//     $date = DateTime::createFromFormat('Y-n', "$tahun-$bulan");
//     $date->modify('-1 month');

//     $bulan_lalu = $date->format('n');
//     $tahun_lalu = $date->format('Y');

//     $bulanIndo = [
//         1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
//         4 => 'April', 5 => 'Mei', 6 => 'Juni',
//         7 => 'Juli', 8 => 'Agustus', 9 => 'September',
//         10 => 'Oktober', 11 => 'November', 12 => 'Desember'
//     ];

//     return $bulanIndo[$bulan_lalu] . " " . $tahun_lalu;
//     }
?>

<body>
    <div class="confidential">PRIVATE & CONFIDENTIAL</div>

    <table class="company" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="width: 150px; vertical-align: middle; padding: 0;">
                <img src="<?= Yii::getAlias('@webroot/img/tbi-logo.png') ?>" width="137" height="43">
            </td>
            <td style="vertical-align: middle; padding: 0;">
                <div style="line-height: 1.3; margin: 0;">
                    <div style="font-weight: bold;">PT TRIBHAKTI INSPEKTAMA</div>
                    <div>Pantai Indah Selatan Street, Blok F No. 31–33</div>
                </div>
            </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

    <table class="header">
        <tr>
            <td><strong>NIK</strong></td>
            <td>: <?= $model->employee->e_number ?></td>
            <td><strong>Lokasi Kerja</strong></td>
            <td>: <?= $model->employee->site_office ?></td>
        </tr>
        <tr>
            <td><strong>Nama</strong></td>
            <td>: <?= $model->employee->fullname ?></td>
            <td><strong>Departemen</strong></td>
            <td>: <?= $model->employee->department ?></td>
        </tr>
        <tr>
            <td><strong>Jabatan</strong></td>
            <td>: <?= $model->employee->jabatan ?></td>
            <td><strong>Periode</strong></td>
            <td>: <?= $model->rmonth->month ?> <?= $model->year ?></td>
        </tr>
    </table>

    <?php
    // $lastmonth = lastmonth($model->year, $model->month);

    // $gaji_pokok = number_format($model->gaji_pokok, 2, ',', '.');
    // $tunjangan_jabatan = number_format($model->tunjangan_jabatan, 2, ',', '.');
    // $tunjangan_operasional = number_format($model->tunjangan_operasional, 2, ',', '.');
    // $tunjangan_lembur = number_format($model->tunjangan_lembur, 2, ',', '.');
    // $tunjangan_akomodasi = number_format($model->tunjangan_akomodasi, 2, ',', '.');
    // $tunjangan_site_office = number_format($model->tunjangan_site_office, 2, ',', '.');
    // $ig = number_format($model->ig, 2, ',', '.');
    // $tunjangan_rangkap = number_format($model->tunjangan_rangkap, 2, ',', '.');
    // $bonus = number_format($model->bonus, 2, ',', '.');
    // $medical_reimburse = number_format($model->medical_reimburse, 2, ',', '.');
    // $lembur = number_format($model->lembur, 2, ',', '.');
    // $revisi_absensi = number_format($model->revisi_absensi, 2, ',', '.');
    // $jht_perusahaan = number_format($model->jht_perusahaan, 2, ',', '.');
    // $jp_perusahaan = number_format($model->jp_perusahaan, 2, ',', '.');
    // $jkm = number_format($model->jkm, 2, ',', '.');
    // $jkk = number_format($model->jkk, 2, ',', '.');
    // $kesehatan_perusahaan = number_format($model->kesehatan_perusahaan, 2, ',', '.');
    // $biaya_perusahaan = number_format($model->biaya_perusahaan, 2, ',', '.');
    // $absensi_10 = number_format($model->absensi_10, 2, ',', '.');
    // $unpaid_leave = number_format($model->unpaid_leave, 2, ',', '.');
    // $pph21 = number_format($model->pph21, 2, ',', '.');
    // $kesehatan_karyawan = number_format($model->kesehatan_karyawan, 2, ',', '.');
    // $jht_karyawan = number_format($model->jht_karyawan, 2, ',', '.');
    // $jp_karyawan = number_format($model->jp_karyawan, 2, ',', '.');
    // $potongan_lain = number_format($model->potongan_lain, 2, ',', '.');
    // $tunjangan_lain = number_format($model->tunjangan_lain, 2, ',', '.');
    // $total_potongan = number_format($model->total_potongan, 2, ',', '.');
    // $thp = number_format($model->thp, 2, ',', '.');

    ?>

    <table class="content">
        <tr class="pendapatan">
            <th colspan="2">INFORMASI PENDAPATAN</th>
            <th colspan="2">PENGURANGAN</th>
        </tr>
    </table>

    <table class="content" width="100%">
        <tr>
            <!-- KOLOM KIRI : INFORMASI PENDAPATAN -->
            <td width="50%" valign="top">

                <table class="content" width="100%">
                    <?php
                    foreach ($detailC as $credit) {
                        $item_name = $credit['item_name'];
                        $amount = $credit['amount'];
                        if($amount == 0){
                            $data_credit = '-';
                        }else{
                            $data_credit = 'Rp' . number_format($amount, 0, ',', '.');
                        }
                    ?>
                    <tr>
                        <td class="left_label"><?= $item_name ?></td>
                        <td class="left_amount">
                            <?= $data_credit ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>

            </td>

            <!-- KOLOM KANAN : PENGURANGAN -->
            <td width="50%" valign="top">

                <table class="content" width="100%">
                    <?php
                    foreach ($detailD as $debit) {
                        $item_name = $debit['item_name'];
                        $amount = $debit['amount'];
                        if($amount == 0){
                            $data_debit = '-';
                        }else{
                            $data_debit = 'Rp' . number_format($amount, 0, ',', '.');
                        }
                    ?>
                    <tr>
                        <td class="right_label"><?= $item_name ?></td>
                        <td class="left_amount">
                            <?= $data_debit ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>

            </td>
        </tr>
    </table>

    <?php
    $biaya_perusahaan = number_format($model->gross, 0, ',', '.');
    $total_potongan = number_format($model->total_deduction, 0, ',', '.');
    $thp = number_format($model->thp, 0, ',', '.');
    ?>

    <table class="content">
        <tr class="footer">
            <td style="padding: 8px;text-align: right;">TOTAL PENDAPATAN</td>
            <td style="padding: 0 12px 0 0;text-align: right;"><strong>Rp <?= $biaya_perusahaan; ?></strong></td>
            <td style="padding: 8px;text-align: right;">TOTAL PENGURANGAN</td>
            <td style="padding: 8px;text-align: right;"><strong>Rp <?= $total_potongan; ?></strong></td>
        </tr>
    </table>


    <table class="total">
        <tr>
            <td style="width: 50%;"></td>
            <td style="font-weight: bold;">PENDAPATAN BERSIH:</td>
            <td style="background-color: yellow; font-weight: bold; border: 2px solid black; text-align: center;">Rp <?= $thp; ?></td>
        </tr>
    </table>

    <p style="text-align: center; font-size: 9px; margin-top: 15px; font-style: italic;">**Slip Gaji ini dicetak menggunakan HR System, tidak membutuhkan stamp atau tanda tangan**</p>




</body>
</html>
