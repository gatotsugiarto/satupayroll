<?php
use \yii\helpers\Url;

$this->title = 'Master Data';
$baseUrl = Yii::$app->request->baseUrl;
?>

<div class="container py-5">
  <div class="row g-4">
    
    <!-- Payroll Profiles -->
    <?php if (\Yii::$app->user->can('backend.master.payrollprofile.index') || \Yii::$app->user->can("root")) { ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4">
      <a href="<?=$baseUrl ?>/master/payrollprofile/index" class="text-decoration-none">
        <div class="card menu-card text-center p-4 h-100">
          <div class="menu-icon mb-2">
            <i class="nc-icon nc-compass-05"></i>
          </div>
          <div class="menu-title fw-bold text-primary">Payroll Profiles</div>
          <div class="menu-desc text-muted">Payroll structure and employee salary configuration</div>
        </div>
      </a>
    </div>
    <?php
    }
    ?>


    <!-- Component -->
    <?php if (\Yii::$app->user->can('backend.master.payrollitem.index') || \Yii::$app->user->can("root")) { ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4">
      <a href="<?=$baseUrl ?>/master/payrollitem/index" class="text-decoration-none">
        <div class="card menu-card text-center p-4 h-100">
          <div class="menu-icon mb-2">
            <i class="nc-icon nc-notes"></i>
          </div>
          <div class="menu-title fw-bold text-primary">Payroll Components</div>
          <div class="menu-desc text-muted">Configure salary components used in payroll calculations</div>
        </div>
      </a>
    </div>
    <?php
    }
    ?>


    <!-- Category -->
    <?php if (\Yii::$app->user->can('backend.master.payrollcategory.index') || \Yii::$app->user->can("root")) { ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4">
      <a href="<?=$baseUrl ?>/master/payrollcategory/index" class="text-decoration-none">
        <div class="card menu-card text-center p-4 h-100">
          <div class="menu-icon mb-2">
            <i class="nc-icon nc-layers-3"></i>
          </div>
          <div class="menu-title fw-bold text-primary">Payroll Categories</div>
          <div class="menu-desc text-muted">Organize payroll components into structured categories</div>
        </div>
      </a>
    </div>
    <?php
    }
    ?>


    <!-- PendingStatus  -->
    <?php if (\Yii::$app->user->can('backend.master.employeepending.index') || \Yii::$app->user->can("root")) { ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4">
      <a href="<?=$baseUrl ?>/master/employeepending/index" class="text-decoration-none">
        <div class="card menu-card text-center p-4 h-100">
          <div class="menu-icon mb-2">
            <i class="nc-icon nc-time-alarm"></i>
          </div>
          <div class="menu-title fw-bold text-primary">Pending Status</div>
          <div class="menu-desc text-muted">Employees with Pending Status</div>
        </div>
      </a>
    </div>
    <?php
    }
    ?>

    <!-- Company -->
    <?php if (\Yii::$app->user->can('backend.master.company.index') || \Yii::$app->user->can("root")) { ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4">
      <a href="<?=$baseUrl ?>/master/company/index" class="text-decoration-none">
        <div class="card menu-card text-center p-4 h-100">
          <div class="menu-icon mb-2">
            <i class="nc-icon nc-bank"></i>
          </div>
          <div class="menu-title fw-bold text-primary">Master Company</div>
          <div class="menu-desc text-muted">Stores company profile data</div>
        </div>
      </a>
    </div>
    <?php
    }
    ?>

    <!-- Application Setting -->
    <?php if (\Yii::$app->user->can('backend.master.applicationsetting.index') || \Yii::$app->user->can("root")) { ?>
    <div class="col-6 col-md-4 col-lg-3 mb-4">
      <a href="<?=$baseUrl ?>/master/applicationsetting/index" class="text-decoration-none">
        <div class="card menu-card text-center p-4 h-100">
          <div class="menu-icon mb-2">
            <i class="nc-icon nc-settings-gear-64"></i>
          </div>
          <div class="menu-title fw-bold text-primary">Application Setting</div>
          <div class="menu-desc text-muted">Configure application parameters and controls</div>
        </div>
      </a>
    </div>
    <?php
    }
    ?>

  </div>
</div>