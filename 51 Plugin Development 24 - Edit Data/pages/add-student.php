<div class="custom-card">
    <h2>
        <?php
        if (isset($action) && $action === "edit") {
            // echo "<pre>";
            // print_r($student);
            echo "Edit Student";
        } else {
            echo "Add Student";
        } ?></h2>

    <?php
    if (!empty($displayMessage)) {
    ?>
        <div class="display-success">
            <?php echo "<h1>" . $displayMessage . "</h2>"; ?>
        </div>
    <?php
    }
    ?>
</div>

<form <?php if ($action === "edit") {
        ?> action="admin.php?page=add-student?action=edit&id=<?php echo $student['id']; ?>" <?php
                                                                                        } else { ?> action="admin.php?page=add-student" <?php } ?> method="POST" class="add-student-form">
    <div class="custom-form-group">
        <label for="name">Name</label>
        <input type="text"
            value="<?php echo isset($student['name']) ? esc_attr($student['name']) : ''; ?>" name="name" placeholder="Enter Name..." required>
    </div>

    <div class="custom-form-group">
        <label for="email">Email</label>
        <input type="email"
            value="<?php echo isset($student['email']) ? esc_attr($student['email']) : ''; ?>"
            name="email" placeholder="Enter Email..." required>
    </div>

    <div class="custom-form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" required>
            <option value="">-- Select Gender --</option>
            <option value="male" <?php selected($student['gender'] ?? '', 'male'); ?>>Male</option>
            <option value="female" <?php selected($student['gender'] ?? '', 'female'); ?>>Female</option>
            <option value="other" <?php selected($student['gender'] ?? '', 'other'); ?>>Other</option>
        </select>
    </div>

    <div class="custom-form-group">
        <label for="phone">Contact</label>
        <input type="tel" value="<?php echo isset($student['phone_no']) ? esc_attr($student['phone_no']) : ''; ?>" pattern="[6-9][0-9]{9}" name="phone" maxlength="10" placeholder="Enter Contact..." required>
    </div>

    <button type="submit" name="btn_submit" class="custom-submit-btn">Submit</button>
</form>
</div>

<style>

</style>