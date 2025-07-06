<?php
global $wpdb;
$message = "";

// Handle Delete Request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['project-delete-id']) && !empty($_POST['project-delete-id'])) {
        $deleted = $wpdb->delete(
            "{$wpdb->prefix}project_system_form_data",
            array("id" => intval($_POST['project-delete-id']))
        );
        if ($deleted) {
            $message = "Project Deleted Successfully";
        } else {
            $message = "Failed to delete project.";
        }
    }
}

// Fetch all projects
$projects = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}project_system_form_data", ARRAY_A);
?>

<div class="container">
    <h2>Project List</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success"><?php echo esc_html($message); ?></div>
    <?php endif; ?>

    <div class="panel panel-primary">
        <div class="panel-heading">List Projects</div>
        <div class="panel-body">
            <p>The <code>.table-bordered</code> class adds borders to a table:</p>
            <div class="row">
                <div class="col-sm-10">
                    <table class="table table-bordered" id="tbl-project">
                        <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Technology</th>
                                <th>Excerpt</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($projects)): ?>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td><?php echo esc_html($project['id']); ?></td>
                                    <td><?php echo esc_html(ucfirst($project['project_name'])); ?></td>
                                    <td><?php echo esc_html($project['client_name']); ?></td>
                                    <td>
                                        <?php
                                            $techs = json_decode($project['tech_used'], true);
                                            echo is_array($techs) ? esc_html(strtolower(implode(', ', $techs))) : 'N/A';
                                        ?>
                                    </td>
                                    <td><?php echo esc_html($project['project_excerpt']); ?></td>
                                    <td>
                                        <a href="admin.php?page=project-system&action=view&projectId=<?php echo $project['id']; ?>" class="btn btn-info">View</a>
                                        <a href="admin.php?page=project-system&action=edit&projectId=<?php echo $project['id']; ?>" class="btn btn-warning">Edit</a>

                                        <form id="frm-delete-project-<?php echo $project['id']; ?>" method="POST" action="">
                                            <?php wp_nonce_field('delete_project_' . $project['id']); ?>
                                            <input type="hidden" name="project-delete-id" value="<?php echo $project['id']; ?>">
                                        </form>

                                        <a href="javascript:void(0);" class="btn btn-danger"
                                           onclick="if (confirm('Are you sure you want to delete this project?')) { document.getElementById('frm-delete-project-<?php echo $project['id']; ?>').submit(); }">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No Projects Found</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
