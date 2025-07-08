<div class="custom-card">
    <h2>Add Student</h2>

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

<form action="admin.php?page=add-student" method="POST" class="add-student-form">
    <div class="custom-form-group">
        <label for="name">Name</label>
        <input type="text" name="name" placeholder="Enter Name..." required>
    </div>

    <div class="custom-form-group">
        <label for="email">Email</label>
        <input type="email" name="email" placeholder="Enter Email..." required>
    </div>

    <div class="custom-form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" required>
            <option value="">-- Select Gender --</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>
    </div>

    <div class="custom-form-group">
        <label for="phone">Contact</label>
        <input type="tel" pattern="[6-9][0-9]{9}" name="phone" maxlength="10" placeholder="Enter Contact..." required>
    </div>

    <button type="submit" name="btn_submit" class="custom-submit-btn">Submit</button>
</form>
</div>

<style>
    
</style>