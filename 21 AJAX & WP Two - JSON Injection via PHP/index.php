<?php get_header(); ?>
<main>

    <h2>AJAX using jquery</h2>
    <p>click button to fetch response from server</p>
    <button id="btn-jquery">Click me</button>

    <div id="output"></div>

    <div id="root"></div>

    <script id="initial-data" type="application/json">
        {
            "websiteName": "<?php bloginfo('name'); ?>",
                "websiteDescription": {
                "desc": "<?php bloginfo('description'); ?>",
                    "url": "<?php bloginfo('url'); ?>"
            }
        }
    </script>

</main>
<?php get_footer(); ?>