<div class="custom-card">
    <h2>Add Student</h2>
    <form action="" method="POST" class="add-student-form">
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
            <label for="contact">Contact</label>
            <input type="tel" pattern="[6-9][0-9]{9}" name="contact" maxlength="10" placeholder="Enter Contact..." required>
        </div>

        <button type="submit" class="custom-submit-btn">Submit</button>
    </form>
</div>

<style>
    .custom-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 30px;
        max-width: 600px;
        margin-top: 20px;
    }

    .custom-card h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #23282d;
    }

    .add-student-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .custom-form-group {
        display: flex;
        flex-direction: column;
    }

    .custom-form-group label {
        margin-bottom: 6px;
        font-weight: 600;
    }

    .custom-form-group input,
    .custom-form-group select {
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #ccd0d4;
        border-radius: 4px;
    }

    .custom-form-group input:focus,
    .custom-form-group select:focus {
        border-color: #2271b1;
        outline: none;
        box-shadow: 0 0 0 1px #2271b1;
    }

    .custom-submit-btn {
        background-color: #2271b1;
        color: #fff;
        padding: 10px 16px;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        align-self: flex-start;
    }

    .custom-submit-btn:hover {
        background-color: #135e96;
    }
</style>
