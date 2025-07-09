<div class="card">
    <h2>List Student</h2>
    <div class="table-container">
        <table class="student-table" id="tbl-student-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // echo "<pre>";
                // print_r($students); 
                ?>
                <?php
                if (count($students) > 0) {
                    foreach ($students as $student) {
                ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['name']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td><?php echo $student['gender']; ?></td>
                            <td><?php echo $student['phone_no']; ?></td>
                            <td>
                                <a href="admin.php?page=add-student&action=view&id=<?php echo $student['id']; ?>"><button class="btn btn-view">View</button></a>
                                <a href="admin.php?page=add-student&action=edit&id=<?php echo $student['id']; ?>"><button class="btn btn-edit">Edit</button></a>

                                <a href="<?php echo wp_nonce_url(
                                                admin_url('admin.php?page=student-system&action=delete&id=' . $student['id']),
                                                'delete_student_' . $student['id']
                                            ); ?>" onclick="return confirm('Are you sure you want to delete this student?');">
                                    <button class="btn btn-delete">Delete</button>
                                </a>

                            </td>
                        </tr>
                <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>
</div>

<style>
    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 1000px;
        margin: auto;
    }

    .card h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .table-container {
        overflow-x: auto;
    }

    .student-table .btn {
        padding: 6px 12px;
        margin-right: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    /* View button */
    .student-table .btn-view {
        background-color: #17a2b8;
        color: white;
    }

    .student-table .btn-view:hover {
        background-color: #138496;
    }

    /* Edit button */
    .student-table .btn-edit {
        background-color: #ffc107;
        color: #212529;
    }

    .student-table .btn-edit:hover {
        background-color: #e0a800;
    }

    /* Delete button */
    .student-table .btn-delete {
        background-color: #dc3545;
        color: white;
    }

    .student-table .btn-delete:hover {
        background-color: #c82333;
    }

    /* Responsive */
    @media (max-width: 600px) {
        .student-table .btn {
            margin-bottom: 5px;
            width: 100%;
        }
    }
</style>