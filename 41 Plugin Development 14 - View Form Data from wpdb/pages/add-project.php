<?php
$message = "";
$status = false;

// defining parameters furthermore to get parameter from URL
$action = "";
$projectId = "";

//find request for view and edit
if (isset($_GET['action']) && isset($_GET['projectId'])) {

    global $wpdb;
    $projectId = $_GET['projectId'];
    // Action === edit
    if ($_GET['action'] === 'edit') {
        $action = "edit";

    }

    // Action === view

    if ($_GET['action'] === 'view') {
        $action = "view";
    }

    //Single project information
    $project = $wpdb->get_row(
        $project = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}project_system_form_data WHERE id=%d", $projectId),
        ARRAY_A
    );
    /* 
        echo "<pre>";
        print_r($project); */


}

// Save Form Data

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btn_submit"])) {
    /* echo "<pre>";
    print_r($_POST);
 */
    global $wpdb;
    $projectName = sanitize_text_field($_POST["projectName"]);
    $clientName = sanitize_text_field($_POST["clientName"]);

    if (isset($_POST["technology"]) && is_array($_POST["technology"])) {
        $technology = json_encode(array_map('sanitize_text_field', $_POST["technology"]));
    } else {
        $technology = json_encode([]); // Store as empty array if none selected
    }

    $projectUrl = sanitize_url($_POST["projectUrl"]);
    $projectExcerpt = sanitize_text_field($_POST["projectExcerpt"]);
    $projectDescription = sanitize_textarea_field($_POST["projectDescription"]);

    $wpdb->insert("{$wpdb->prefix}project_system_form_data", array(
        "project_name" => $projectName,
        "client_name" => $clientName,
        "tech_used" => $technology,
        "project_url" => $projectUrl,
        "project_excerpt" => $projectExcerpt,
        "project_desc" => $projectDescription
    ));

    $last_insert_id = $wpdb->insert_id;

    if ($last_insert_id > 0) {
        $message = "project saved successfully";
        $status = 1;
    } else {
        $message = "failed to save data";
        $status = 0;
    }
}
?>
<div class="container">
    <h2>
        <?php
        if ($action === "view") {
            echo "View Project";
        } else {
            echo "Add Project";
        }
        ?>

    </h2>
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">Add Project</div>
                <div class="panel-body">

                    <?php
                    if (!empty($message)) {
                        if ($status === 1) {
                            ?>
                            <div class="alert alert-success">
                                <?php echo $message; ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-danger">
                                <?php echo $message; ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>?page=project-system" method="POST"
                        id="project-system-frm">
                        <div class="form-group">
                            <label for="project-name">Project Name:</label>
                            <input type="text" value="<?php if ($action === 'view') {
                                echo $project['project_name'];
                            } ?>" <?php echo ($action === 'view') ? 'readonly' : ''; ?> required class="form-control"
                                id="project-name" placeholder="Enter Project Name" name="projectName">
                        </div>
                        <div class="form-group">
                            <label for="client">Client Name:</label>
                            <input type="text" value="<?php if ($action === 'view') {
                                echo $project['client_name'];
                            } ?>" <?php echo ($action === 'view') ? 'readonly' : ''; ?> class="form-control" id="client"
                                placeholder="Enter Client Name" name="clientName">
                        </div>
                        <div class="form-group">
                            <label>Technologies Used</label><br>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="React"> React
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="WordPress"> WordPress
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="PHP"> PHP
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="TailwindCSS"> TailwindCSS
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="Vanilla JS"> Vanilla JS
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="jQuery"> jQuery
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="MySQL"> MySQL
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="technology[]" value="Advanced Excel"> Advanced Excel
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="project-url">Project URL:</label>
                            <input type="url" value="<?php if ($action === 'view') {
                                echo $project['project_url'];
                            } ?>" <?php echo ($action === 'view') ? 'readonly' : ''; ?> class="form-control"
                                id="project-url" placeholder="Enter Project URL" name="projectUrl">
                        </div>
                        <div class="form-group">
                            <label for="project-excerpt">Project Excerpt:</label>
                            <input type="text" value="<?php if ($action === 'view') {
                                echo $project['project_excerpt'];
                            } ?>" <?php echo ($action === 'view') ? 'readonly' : ''; ?> required class="form-control"
                                id="project-excerpt" placeholder="Enter Project Excerpt" name="projectExcerpt">
                        </div>

                        <div class="form-group">
                            <label for="project-description">Project Description:</label>
                            <textarea <?php echo ($action === 'view') ? 'readonly' : ''; ?> class="form-control"
    id="project-description" rows="5" placeholder="Enter Project Description"
    name="projectDescription"><?php if ($action === 'view') { echo esc_textarea($project['project_desc']); } ?></textarea>

                        </div>

                        <button type="submit" name="btn_submit" class="btn btn-success" <?php echo ($action === 'view') ? 'disabled' : ''; ?>>Add Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<img style="width:200px" src="<?php echo PROJECT_PLUGIN_URL . "/assets/adi.png" ?>" alt="">