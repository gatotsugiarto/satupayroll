<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 text-primary">
            <i class="fa fa-user-shield me-2"></i> Role Assignment
        </h5>
    </div>

    <div class="card-body">

        <?php $form = ActiveForm::begin(); ?>

        <!-- NAME -->
        <div class="mb-3">
            <label class="form-label fw-semibold text-uppercase small text-muted mb-1">Name</label>
            <div class="fw-semibold"><?= Html::encode($model->name) ?></div>
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-4">
            <label class="form-label fw-semibold text-uppercase small text-muted mb-1">Description</label>
            <div><?= nl2br(Html::encode($model->description)) ?></div>
        </div>

        <!-- CURRENT ROLE PERMISSIONS TABLE -->
        <?php if ($roleAssignment): ?>
            <div class="table-wrapper mb-4">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Assigned</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($roleAssignment as $key => $value): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>
                                <?php
                                $typeLabel = $value->type === \yii\rbac\Item::TYPE_ROLE ? 'Role' : 'Permission';
    							$badgeClass = $value->type === \yii\rbac\Item::TYPE_ROLE ? 'badge bg-primary px-2 py-1' : 'badge bg-warning px-2 py-1';
                                ?>
                                <td class="text-left">
                                    <span class="<?= $badgeClass ?>"><?= $typeLabel ?></span>
                                </td>
                                <td class="text-left"><?= Html::encode($key) ?></td>
                                <td class="text-center">
                                    <?= Html::a(
                                        '<i class="fa fa-trash"></i>',
                                        ['deleteroleassign', 'parent' => $model->name, 'name' => $key],
                                        ['class' => 'btn btn-sm btn-outline-danger rounded-circle']
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <?php
        // Roles Select
        $rolepermissionAssignments = array_keys($roleAssignment ?? []);
        $roles = [];

        foreach ($allRoles as $role) {
            if ($role->name !== $model->name) {
                $roles[$role->name] = $role->name;
            }
        }

        $roleOptions = array_diff($roles, $rolepermissionAssignments);
        ?>

        <!-- ADD ROLES -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Add Roles</label>
            <?= Html::dropDownList('roles', null, $roleOptions, [
                'multiple' => true,
                'class' => 'form-select',
                'size' => 6,
            ]) ?>
        </div>

        <?php
        // Permissions Select
        $permissions = [];

        foreach ($allPermissions as $permission) {
            if (strpos($permission->name, '*') === false) {
                $permissions[$permission->name] = $permission->name;
            }
        }

        $permissionOptions = array_diff($permissions, $rolepermissionAssignments);
        ?>

        <!-- ADD PERMISSIONS -->
        <div class="mb-4">
            <label class="form-label fw-semibold">Add Permissions</label>
            <?= Html::dropDownList('permissions', null, $permissionOptions, [
                'multiple' => true,
                'class' => 'form-select',
                'size' => 6,
            ]) ?>
        </div>

        <!-- HIDDEN FIELDS -->
        <?= $form->field($model, 'rule_name')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'data')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'created_at')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'updated_at')->hiddenInput()->label(false) ?>

        <!-- BUTTONS -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <?= Html::a('<i class="fa fa-arrow-left"></i> Back', ['role'], ['class' => 'btn btn-light']) ?>
            <?= Html::submitButton('<i class="fa fa-check"></i> Submit', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
