<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
?>

<style>
.login-page {
    min-height: 100vh;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-card {
    width: 480px;
}

.login-card-header {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
}

.login-card-header h3 {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin: 0;
}

.toggle-password {
    cursor: pointer;
}

.toggle-password i {
    font-size: 1rem;
    transition: 0.2s;
}

.toggle-password:hover i {
    color: #000;
}
</style>

<div class="login-page">
    <div class="card shadow-lg border-0 rounded-4 login-card">
        
        <!-- Header -->
        <div class="login-card-header text-white text-center rounded-top py-3">
            <h3 class="fw-bold">
                <i class="fa fa-lock"></i>
                <?= Html::encode($this->title) ?>
            </h3>
        </div>

        <!-- Body -->
        <div class="card-body p-4">

            <p class="text-muted text-center mb-4">
                Please enter your credentials to access the dashboard.
            </p>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <!-- Username -->
            <div class="mb-3">
                <?= $form->field($model, 'username')->textInput([
                    'autofocus' => true,
                    'placeholder' => 'Username',
                    'class' => 'form-control rounded-pill py-2'
                ])->label(false) ?>
            </div>

            <!-- Password -->
            <div class="mb-3 position-relative">
                <?= $form->field($model, 'password')->passwordInput([
                    'placeholder' => 'Password',
                    'class' => 'form-control rounded-pill py-2',
                    'id' => 'password-input'
                ])->label(false) ?>

                <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3 text-muted" onclick="togglePassword()">
                    <i class="fa fa-eye"></i>
                </span>
            </div>

            <!-- Remember Me -->
            <div class="mb-3">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                    'class' => 'form-check-input',
                    'labelOptions' => ['class' => 'form-check-label ms-1']
                ]) ?>
            </div>

            <!-- Submit -->
            <div class="d-grid">
                <?= Html::submitButton('Login', [
                    'class' => 'btn btn-primary btn-lg rounded-pill shadow-sm fw-bold',
                    'name' => 'login-button'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password-input');
    const icon = document.querySelector('.toggle-password i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
