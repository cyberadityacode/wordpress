<div class="container">
    <h2>Add Project</h2>
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">Add Project</div>
                <div class="panel-body">
                    <form action="/action_page.php">
                        <div class="form-group">
                            <label for="project-name">Project Name:</label>
                            <input type="text" class="form-control" id="project-name" placeholder="Enter Project Name"
                                name="projectName">
                        </div>
                        <div class="form-group">
                            <label for="client">Client Name:</label>
                            <input type="text" class="form-control" id="client" placeholder="Enter Client Name"
                                name="clientName">
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
                            <input type="url" class="form-control" id="project-url" placeholder="Enter Project URL"
                                name="projectUrl">
                        </div>
                        <div class="form-group">
                            <label for="project-excerpt">Project Excerpt:</label>
                            <input type="text" class="form-control" id="project-excerpt"
                                placeholder="Enter Project Excerpt" name="projectExcerpt">
                        </div>

                        <div class="form-group">
                            <label for="project-description">Project Description:</label>
                            <textarea class="form-control" id="project-description" rows="5"
                                placeholder="Enter Project Description" name="projectDescription"></textarea>
                        </div>





                        <button type="submit" class="btn btn-success">Add Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<img style="width:200px" src="<?php echo PROJECT_PLUGIN_URL . "/assets/adi.png" ?>" alt="">