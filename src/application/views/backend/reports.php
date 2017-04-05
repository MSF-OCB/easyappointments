
<link rel="stylesheet" type="text/css"
      href="<?php echo $base_url; ?>/assets/ext/jquery-datatables-2/jquery.datatables.css" />
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/ext/jquery-datatables-2/jquery.datatables.min.js"></script>

<script type="text/javascript">
    var GlobalVariables = {
        'csrfToken'         : <?php echo json_encode($this->security->get_csrf_hash()); ?>,
        'availableProviders': <?php echo json_encode($available_providers); ?>,
        'availableServices' : <?php echo json_encode($available_services); ?>,
        'dateFormat'        : <?php echo json_encode($date_format); ?>,
        'baseUrl'           : <?php echo json_encode($base_url); ?>,
        'customers'         : <?php echo json_encode($customers); ?>,
        'user'              : {
            'id'        : <?php echo $user_id; ?>,
            'email'     : <?php echo json_encode($user_email); ?>,
            'role_slug' : <?php echo json_encode($role_slug); ?>,
            'privileges': <?php echo json_encode($privileges); ?>
        }
    };


    $(document).ready(function() {

        var table = $('#example').DataTable( {
            "data" : <?php echo json_encode($appointments); ?>
        });


    });
</script>

<div id="reports-page" class="container-fluid backend-page">
	<div class="row">
		<button type="button" class="DTTT_button" id="clearAll2" name="clearAll">Reset all filters</button>
		<div class="col-xs-12">
			<table id="labtech" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('date');?></th>
						<th><?php echo $this->lang->line('category');?></th>
						<th><?php echo $this->lang->line('service');?></th>
						<th><?php echo $this->lang->line('provider');?></th>
						<th><?php echo $this->lang->line('customer');?></th>
						<th><?php echo $this->lang->line('gender');?></th>
						<th><?php echo $this->lang->line('address');?></th>
						<th><?php echo $this->lang->line('country');?></th>
						<th><?php echo $this->lang->line('language');?></th>
						<th><?php echo $this->lang->line('status');?></th>
					</tr>
				</thead>

			</table>
		</div>
	</div>
</div>
