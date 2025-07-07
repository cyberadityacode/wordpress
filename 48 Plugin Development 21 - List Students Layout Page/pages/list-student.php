<div class="card">
    <h2>List Student</h2>
    <div class="table-container">
        <table class="student-table">
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
                <tr>
                    <td>1</td>
                    <td>Aditya Dubey</td>
                    <td>aditya@gmail.com</td>
                    <td>Male</td>
                    <td>9876543210</td>
                    <td>
                        <button>View</button>
                        <button>Edit</button>
                        <button>Delete</button>
                    </td>
                </tr>
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

    .student-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    .student-table thead {
        background-color: #007bff;
        color: white;
    }

    .student-table th,
    .student-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .student-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .student-table tbody tr:hover {
        background-color: #f1f1f1;
    }

    .student-table button {
        padding: 6px 12px;
        margin-right: 5px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .student-table button:nth-child(1) {
        background-color: #17a2b8;
        color: white;
    }

    .student-table button:nth-child(1):hover {
        background-color: #138496;
    }

    .student-table button:nth-child(2) {
        background-color: #ffc107;
        color: #212529;
    }

    .student-table button:nth-child(2):hover {
        background-color: #e0a800;
    }

    .student-table button:nth-child(3) {
        background-color: #dc3545;
        color: white;
    }

    .student-table button:nth-child(3):hover {
        background-color: #c82333;
    }

    @media (max-width: 600px) {

        .student-table th,
        .student-table td {
            padding: 10px;
            font-size: 14px;
        }

        .student-table button {
            margin-bottom: 5px;
            width: 100%;
        }
    }
</style>