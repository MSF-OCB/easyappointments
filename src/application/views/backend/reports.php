
<link rel="stylesheet" type="text/css"
      href="<?php echo $base_url; ?>/assets/ext/jquery-datatables-2/jquery.datatables.css" />
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/ext/jquery-datatables-2/jquery.datatables.min.js"></script>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_reports_helper.js"></script>
<style type="text/css">
    .form-group {
        margin: auto 10px;
    }
</style>
<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_reports.js"></script>
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
        BackendReports.initialize();

        var table = $('#labtech').DataTable( {
            "aaData" :  <?php echo json_encode($reports); ?>,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            columns: [
                { title: "<?php echo $this->lang->line('start_date');?>" },
                { title: "<?php echo $this->lang->line('category');?>" },
                { title: "<?php echo $this->lang->line('service');?>" },
                { title: "<?php echo $this->lang->line('provider');?>" },
                { title: "<?php echo $this->lang->line('customer');?>" },
                { title: "<?php echo $this->lang->line('gender');?>" },
                { title: "<?php echo $this->lang->line('address');?>" },
                { title: "<?php echo $this->lang->line('phone');?>" },
                { title: "<?php echo $this->lang->line('country');?>" },
                { title: "<?php echo $this->lang->line('language');?>" },
                { title: "<?php echo $this->lang->line('status');?>" }
            ],
            "aoColumns": [
                { "mDataProp": "start" },
                { "mDataProp": "category_name" },
                { "mDataProp": "service_name" },
                { "mDataProp": "provider_name" },
                { "mDataProp": "customer_name" },
                { "mDataProp": "gender" },
                { "mDataProp": "address" },
                { "mDataProp": "phone_number_1" },
                { "mDataProp": "country_origin" },
                { "mDataProp": "language" },
                { "mDataProp": "status" }
            ]
        });
        $( '#tableFilters input').on( 'keyup change', function () {
            table.draw()
        } );
     });





</script>

<div id="reports-page" class="container-fluid backend-page">
	<div class="row">

		<div class="col-xs-10 col-xs-offset-1">
            <form class="form-inline" id="tableFilters" style="border: 1px solid #aaa; padding: 8px;">
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
                <div class="form-group">
                    <label for="exampleInputName2">Name</label>
                    <input type="text" class="form-control" id="exampleInputName2" placeholder="Jane Doe">
                </div>
            </form>

            <table id="labtech" class="table table-condensed table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th><?php echo $this->lang->line('date');?></th>
						<th><?php echo $this->lang->line('category');?></th>
						<th><?php echo $this->lang->line('service');?></th>
						<th><?php echo $this->lang->line('provider');?></th>
						<th><?php echo $this->lang->line('customer');?></th>
						<th><?php echo $this->lang->line('gender');?></th>
						<th><?php echo $this->lang->line('address');?></th>
						<th><?php echo $this->lang->line('phone');?></th>
						<th><?php echo $this->lang->line('country');?></th>
						<th><?php echo $this->lang->line('language');?></th>
						<th><?php echo $this->lang->line('status');?></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
