<div id="footer">
    <div id="footer-content" class="col-xs-12 col-md-6">
        Powered by
        <a href="http://easyappointments.org">Easy!Appointments
            <?php
                echo 'v' . $this->config->item('version');

                $release_title = $this->config->item('release_label');
                if ($release_title != '') {
                    echo ' - ' . $release_title;
                }
            ?></a> |
        <?php echo $this->lang->line('licensed_under'); ?> GPLv3 |
        <span id="select-language" class="label label-success">
        	<?php echo ucfirst($this->config->item('language')); ?>
        </span>
        |
        <a href="<?php echo site_url('appointments'); ?>">
            <?php echo $this->lang->line('go_to_booking_page') ?>
        </a>
        <a style="padding-left: 0.5cm; color:red; font-weight:bold;" href="mailto:ehealth-support@brussels.msf.org">
            <?php echo $this->lang->line('need_support') ?>
        </a>
    </div>

    <div id="footer-user-display-name" class="col-xs-12 col-md-6">
        <?php echo $this->lang->line('hello') . ', ' . $user_display_name; ?>!
    </div>
</div>

<script
    type="text/javascript"
    src="<?php echo $base_url; ?>/assets/js/backend.js"></script>
<script
    type="text/javascript"
    src="<?php echo $base_url; ?>/assets/js/general_functions.js"></script>
</body>
</html>
