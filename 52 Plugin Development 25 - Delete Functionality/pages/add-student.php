<?php $is_view = ($action === "view"); ?>

<div class="custom-card">
    <h2>
        <?php
        if ($action === "edit") {
            echo "Edit Student";
        } elseif ($is_view) {
            echo "View Student";
        } else {
            echo "Add Student";
        }
        ?>
    </h2>

    <?php if (!empty($displayMessage)) : ?>
        <div class="display-success">
            <h3><?php echo esc_html($displayMessage); ?></h3>
        </div>
    <?php endif; ?>
</div>

<form action="" method="POST" class="add-student-form">
    <?php if (!$is_view) : ?>
        <?php wp_nonce_field('save_student_data', 'student_nonce'); ?>
    <?php endif; ?>

    <?php if (($action === 'edit' || $is_view) && !empty($student['id'])) : ?>
        <input type="hidden" name="student_id" value="<?php echo esc_attr($student['id']); ?>">
    <?php endif; ?>

    <div class="custom-form-group">
        <label for="name">Name</label>
        <input type="text"
            name="name"
            value="<?php echo isset($student['name']) ? esc_attr($student['name']) : ''; ?>"
            placeholder="Enter Name..."
            <?php echo $is_view ? 'readonly' : ''; ?> required>
    </div>

    <div class="custom-form-group">
        <label for="email">Email</label>
        <input type="email"
            name="email"
            value="<?php echo isset($student['email']) ? esc_attr($student['email']) : ''; ?>"
            placeholder="Enter Email..."
            <?php echo $is_view ? 'readonly' : ''; ?> required>
    </div>

    <div class="custom-form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" <?php echo $is_view ? 'disabled' : ''; ?> required>
            <option value="">-- Select Gender --</option>
            <option value="male" <?php selected($student['gender'] ?? '', 'male'); ?>>Male</option>
            <option value="female" <?php selected($student['gender'] ?? '', 'female'); ?>>Female</option>
            <option value="other" <?php selected($student['gender'] ?? '', 'other'); ?>>Other</option>
        </select>
    </div>

    <div class="custom-form-group">
        <label for="phone">Contact</label>
        <input type="tel"
            name="phone"
            pattern="[6-9][0-9]{9}"
            maxlength="10"
            value="<?php echo isset($student['phone_no']) ? esc_attr($student['phone_no']) : ''; ?>"
            placeholder="Enter Contact..."
            <?php echo $is_view ? 'readonly' : ''; ?> required>
    </div>

    <?php if (!$is_view) : ?>
        <button type="submit" name="btn_submit" class="custom-submit-btn">
            <?php echo ($action === "edit") ? 'Update' : 'Submit'; ?>
        </button>
    <?php endif; ?>
</form>
