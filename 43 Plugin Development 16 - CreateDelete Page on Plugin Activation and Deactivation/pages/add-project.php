<?php
$message = "";
$status = false;
$action = "";
$projectId = "";
$project = [];
$selected_tech = [];

// Handle action from URL
if (isset($_GET['action'], $_GET['projectId'])) {
    global $wpdb;

    $action = sanitize_text_field($_GET['action']);
    $projectId = intval($_GET['projectId']);

    if (in_array($action, ['edit', 'view'])) {
        $project = $wpdb->get_row(
            $wpdb->prepare("SELECT * FROM {$wpdb->prefix}project_system_form_data WHERE id=%d", $projectId),
            ARRAY_A
        );

        $selected_tech = isset($project['tech_used']) ? json_decode($project['tech_used'], true) : [];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["btn_submit"])) {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_project')) {
        wp_die('Security check failed');
    }

    global $wpdb;

    $projectName = sanitize_text_field($_POST["projectName"]);
    $clientName = sanitize_text_field($_POST["clientName"]);
    $technology = isset($_POST["technology"]) && is_array($_POST["technology"])
        ? json_encode(array_map('sanitize_text_field', $_POST["technology"]))
        : json_encode([]);
    $projectUrl = sanitize_url($_POST["projectUrl"]);
    $projectExcerpt = sanitize_text_field($_POST["projectExcerpt"]);
    $projectDescription = sanitize_textarea_field($_POST["projectDescription"]);

    if (isset($_GET['action']) && $_GET['action'] === 'edit' && !empty($_GET['projectId'])) {
        $projectId = intval($_GET['projectId']);

        $wpdb->update(
            "{$wpdb->prefix}project_system_form_data",
            [
                "project_name" => $projectName,
                "client_name" => $clientName,
                "tech_used" => $technology,
                "project_url" => $projectUrl,
                "project_excerpt" => $projectExcerpt,
                "project_desc" => $projectDescription
            ],
            ['id' => $projectId]
        );

        $message = "Project updated successfully";
        $status = 1;
    } else {
        $wpdb->insert(
            "{$wpdb->prefix}project_system_form_data",
            [
                "project_name" => $projectName,
                "client_name" => $clientName,
                "tech_used" => $technology,
                "project_url" => $projectUrl,
                "project_excerpt" => $projectExcerpt,
                "project_desc" => $projectDescription
            ]
        );

        $last_insert_id = $wpdb->insert_id;

        if ($last_insert_id > 0) {
            $message = "Project saved successfully";
            $status = 1;

            // Optional: Redirect after insert to avoid form resubmission
            // wp_redirect(admin_url("admin.php?page=project-system&action=view&projectId=$last_insert_id"));
            // exit;
        } else {
            $message = "Failed to save data";
            $status = 0;
        }
    }
}
?>

<div class="container">
    <h2><?php echo ucfirst($action ?: 'add'); ?> Project</h2>

    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo ucfirst($action ?: 'add'); ?> Project</div>
                <div class="panel-body">

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-<?php echo $status === 1 ? 'success' : 'danger'; ?>">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?php
                        echo admin_url('admin.php?page=project-system' .
                            ($action === 'edit' ? "&action=edit&projectId=$projectId" : ''));
                        ?>"
                        method="POST" id="project-system-frm">

                        <?php wp_nonce_field('save_project'); ?>

                        <div class="form-group">
                            <label for="project-name">Project Name:</label>
                            <input type="text"
                                   value="<?php echo esc_attr($project['project_name'] ?? ''); ?>"
                                   <?php echo $action === 'view' ? 'readonly' : ''; ?>
                                   required class="form-control"
                                   id="project-name"
                                   placeholder="Enter Project Name"
                                   name="projectName">
                        </div>

                        <div class="form-group">
                            <label for="client">Client Name:</label>
                            <input type="text"
                                   value="<?php echo esc_attr($project['client_name'] ?? ''); ?>"
                                   <?php echo $action === 'view' ? 'readonly' : ''; ?>
                                   class="form-control"
                                   id="client"
                                   placeholder="Enter Client Name"
                                   name="clientName">
                        </div>

                        <div class="form-group">
                            <label>Technologies Used</label><br>
                            <?php
                            $all_tech = ["React", "WordPress", "PHP", "TailwindCSS", "Vanilla JS", "jQuery", "MySQL", "Advanced Excel"];
                            foreach ($all_tech as $tech) {
                                $checked = in_array($tech, $selected_tech) ? 'checked' : '';
                                $disabled = $action === 'view' ? 'disabled' : '';
                                echo "<label class='checkbox-inline'>
                                    <input type='checkbox' name='technology[]' value='{$tech}' {$checked} {$disabled}> {$tech}
                                </label>";
                            }
                            ?>
                        </div>

                        <div class="form-group">
                            <label for="project-url">Project URL:</label>
                            <input type="url"
                                   value="<?php echo esc_url($project['project_url'] ?? ''); ?>"
                                   <?php echo $action === 'view' ? 'readonly' : ''; ?>
                                   class="form-control"
                                   id="project-url"
                                   placeholder="Enter Project URL"
                                   name="projectUrl">
                        </div>

                        <div class="form-group">
                            <label for="project-excerpt">Project Excerpt:</label>
                            <input type="text"
                                   value="<?php echo esc_attr($project['project_excerpt'] ?? ''); ?>"
                                   <?php echo $action === 'view' ? 'readonly' : ''; ?>
                                   required class="form-control"
                                   id="project-excerpt"
                                   placeholder="Enter Project Excerpt"
                                   name="projectExcerpt">
                        </div>

                        <div class="form-group">
                            <label for="project-description">Project Description:</label>
                            <textarea <?php echo $action === 'view' ? 'readonly' : ''; ?>
                                      class="form-control"
                                      id="project-description"
                                      rows="5"
                                      placeholder="Enter Project Description"
                                      name="projectDescription"><?php echo esc_textarea($project['project_desc'] ?? ''); ?></textarea>
                        </div>

                        <?php if ($action !== 'view'): ?>
                            <button type="submit"
                                    name="btn_submit"
                                    class="btn btn-<?php echo $action === 'edit' ? 'info' : 'success'; ?>">
                                <?php echo $action === 'edit' ? 'Update' : 'Add'; ?> Project
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<img style="width:200px" src="<?php echo esc_url(PROJECT_PLUGIN_URL . "/assets/adi.png"); ?>" alt="">
