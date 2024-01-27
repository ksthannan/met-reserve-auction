<form method="POST" action="options.php">
<?php
    settings_fields('gyc_plugin_opt');
    do_settings_sections('gyc_plugin_opt');
    submit_button();
    ?>
</form>