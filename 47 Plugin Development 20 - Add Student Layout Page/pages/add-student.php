<div class="card">
    <h2>Add Student</h2>
    <form action="" method="POST" class="add-student-form">
        <!-- Name -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Enter Name..." required>
        </div>
        <!-- Email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Enter Email..." required>
        </div>

        <!-- Gender -->
        <div class="form-group">
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>

        <!-- Contact -->
        <div class="form-group">
            <label for="contact">Contact</label>
            <input type="tel" pattern="[0-9]{10}" name="contact" placeholder="Enter Contact..." required>
        </div>

        <button type="submit">Submit</button>


    </form>
</div>