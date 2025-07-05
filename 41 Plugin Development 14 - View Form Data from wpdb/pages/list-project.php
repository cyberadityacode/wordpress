<?php
global $wpdb;
// $projects = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}project_system_form_data ");
$projects = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}project_system_form_data ", ARRAY_A);

/* echo "<pre>";
print_r($projects);

 */
?>


<div class="container">
    <h2>Bordered Table</h2>
    <div class="container">
        <h2>Panel Heading</h2>
        <div class="panel panel-primary">
            <div class="panel-heading">List Projects</div>
            <div class="panel-body">
                <p>The .table-bordered class adds borders to a table:</p>
                <div class="row">
                    <div class="col-sm-10">
                        <table class="table table-bordered" id="tbl-project">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>#Project Name</th>
                                    <th>#Client</th>
                                    <th>#Technology</th>
                                    <th>#Excerpt</th>
                                    <th>#Options</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                if (count($projects) > 0) {
                                    foreach ($projects as $project) {
                                        ?>
                                        <tr>
                                            <td><?php echo $project['id']; ?></td>
                                            <td><?php echo ucfirst($project['project_name']); ?></td>
                                            <td><?php echo $project['client_name']; ?></td>

                                            <td>
                                                <?php
                                                $techs = json_decode($project['tech_used'], true);
                                                if (is_array($techs)) {
                                                    echo strtolower(implode(', ', $techs));
                                                } else {
                                                    echo 'N/A';
                                                }
                                                ?>
                                            </td>



                                            <td><?php echo $project['project_excerpt']; ?></td>


                                            <td>
                                                <a href="admin.php?page=project-system&action=view&projectId=<?php echo $project['id']; ?>"
                                                    class="btn btn-info">View</a>
                                                <a href="admin.php?page=project-system&action=edit&projectId=<?php echo $project['id']; ?>"
                                                    class="btn btn-warning">Edit</a>
                                                <!-- project-list-project -->
                                                <a href="admin.php?page=project-list-project&action=delete&projectId=<?php echo $project['id']; ?>"
                                                    class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "No Project Found";
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>