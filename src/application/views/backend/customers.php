<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/ext/jquery-ui/jquery-ui-timepicker-addon.js"></script>

<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_customers_helper.js"></script>

<script type="text/javascript"
        src="<?php echo $base_url; ?>/assets/js/backend_customers.js"></script>

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
        BackendCustomers.initialize(true);
    });
</script>

<div id="customers-page" class="container-fluid backend-page">
    <div class="row">
    	<div id="filter-customers" class="filter-records column col-xs-12 col-sm-5">
    		<form class="input-append">
    			<input class="key" type="text" />
                <div class="btn-group">
                    <button class="filter btn btn-default btn-sm" type="submit" title="<?php echo $this->lang->line('filter'); ?>">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    <button class="clear btn btn-default btn-sm" type="button" title="<?php echo $this->lang->line('clear'); ?>">
                        <span class="glyphicon glyphicon-repeat"></span>
                    </button>
                </div>
    		</form>

            <h3><?php echo $this->lang->line('customers'); ?></h3>
            <div class="results"></div>
    	</div>

    	<div class="record-details col-xs-12 col-sm-7">
            <div class="btn-toolbar">
                <div id="add-edit-delete-group" class="btn-group">
                    <?php if ($privileges[PRIV_CUSTOMERS]['add'] == TRUE) { ?>
                    <button id="add-customer" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>
                        <?php echo $this->lang->line('add'); ?>
                    </button>
                    <?php } ?>

                    <?php if ($privileges[PRIV_CUSTOMERS]['edit'] == TRUE) { ?>
                    <button id="edit-customer" class="btn btn-default" disabled="disabled">
                        <span class="glyphicon glyphicon-pencil"></span>
                        <?php echo $this->lang->line('edit'); ?>
                    </button>
                    <?php }?>

                    <?php if ($privileges[PRIV_CUSTOMERS]['delete'] == TRUE) { ?>
                    <button id="delete-customer" class="btn btn-default" disabled="disabled">
                        <span class="glyphicon glyphicon-remove"></span>
                        <?php echo $this->lang->line('delete'); ?>
                    </button>
                    <?php } ?>
                </div>

                <div id="save-cancel-group" class="btn-group" style="display:none;">
                    <button id="save-customer" class="btn btn-primary">
                        <span class="glyphicon glyphicon-ok"></span>
                        <?php echo $this->lang->line('save'); ?>
                    </button>
                    <button id="cancel-customer" class="btn btn-default">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <?php echo $this->lang->line('cancel'); ?>
                    </button>
                </div>
            </div>

            <input id="customer-id" type="hidden" />

            <div class="row">
                <div class="col-md-6" style="margin-left: 0;">
                    <h3><?php echo $this->lang->line('details'); ?></h3>
                    <div id="form-message" class="alert" style="display:none;"></div>

                    <div class="form-group">
                        <label for="first-name"><?php echo $this->lang->line('first_name'); ?> *</label>
                        <input type="text" id="first-name" class="form-control required" />
                    </div>

                    <div class="form-group">
                        <label for="last-name"><?php echo $this->lang->line('last_name'); ?> *</label>
                        <input type="text" id="last-name" class="form-control required" />
                    </div>
                    
                    <div class="form-group">
                        <label for="gender"><?php echo $this->lang->line('gender'); ?> *</label>
                            <select id="gender" class="required form-control">
                                      <option value="M"><?php echo $this->lang->line('male'); ?></option>
                                      <option value="F"><?php echo $this->lang->line('female'); ?></option>
                                      <option value="O"><?php echo $this->lang->line('other'); ?></option>
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="email"><?php echo $this->lang->line('email'); ?></label>
                        <input type="text" id="email" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label for="phone-number-1"><?php echo $this->lang->line('phone_number_1'); ?> *</label>
                        <input type="text" id="phone-number-1" class="form-control required" />
                    </div>

                    <div class="form-group">
                        <label for="phone-number-2"><?php echo $this->lang->line('phone_number_2'); ?></label>
                        <input type="text" id="phone-number-2" class="form-control" />
                    </div>
                    
                    <div class="form-group">
                        <label for="address"><?php echo $this->lang->line('address'); ?> *</label>
                        <input type="text" id="address" class="form-control required" />
                    </div>

                    <div class="form-group">
                        <label for="country"><?php echo $this->lang->line('country_origin'); ?> *</label>
                            <select id="country" class="required form-control">
                                <option value="AF"><?php echo $countries['AF']; ?></option>
                                <option value="DZ"><?php echo $countries['DZ']; ?></option>
                                <option value="BD"><?php echo $countries['BD']; ?></option>
                                <option value="BF"><?php echo $countries['BF']; ?></option>
                                <option value="CM"><?php echo $countries['CM']; ?></option>
                                <option value="CF"><?php echo $countries['CF']; ?></option>
                                <option value="TD"><?php echo $countries['TD']; ?></option>
                                <option value="CG"><?php echo $countries['CG']; ?></option>
                                <option value="CD"><?php echo $countries['CD']; ?></option>
                                <option value="DO"><?php echo $countries['DO']; ?></option>
                                <option value="EG"><?php echo $countries['EG']; ?></option>
                                <option value="ER"><?php echo $countries['ER']; ?></option>
                                <option value="ET"><?php echo $countries['ET']; ?></option>
                                <option value="GM"><?php echo $countries['GM']; ?></option>
                                <option value="GH"><?php echo $countries['GH']; ?></option>
                                <option value="GW"><?php echo $countries['GW']; ?></option>
                                <option value="GN"><?php echo $countries['GN']; ?></option>
                                <option value="IN"><?php echo $countries['IN']; ?></option>
                                <option value="IQ"><?php echo $countries['IQ']; ?></option>
                                <option value="IR"><?php echo $countries['IR']; ?></option>
                                <option value="IV"><?php echo $countries['CI']; ?></option>
                                <option value="LB"><?php echo $countries['LB']; ?></option>
                                <option value="LY"><?php echo $countries['LY']; ?></option>
                                <option value="ML"><?php echo $countries['ML']; ?></option>
                                <option value="MA"><?php echo $countries['MA']; ?></option>
                                <option value="MM"><?php echo $countries['MM']; ?></option>
                                <option value="NP"><?php echo $countries['NP']; ?></option>
                                <option value="NE"><?php echo $countries['NE']; ?></option>
                                <option value="NG"><?php echo $countries['NG']; ?></option>
                                <option value="PK"><?php echo $countries['PK']; ?></option>
                                <option value="PX"><?php echo $countries['PX']; ?></option>
                                <option value="PS"><?php echo $countries['PS']; ?></option>
                                <option value="SN"><?php echo $countries['SN']; ?></option>
                                <option value="RS"><?php echo $countries['RS']; ?></option>
                                <option value="SO"><?php echo $countries['SO']; ?></option>
                                <option value="SY"><?php echo $countries['SY']; ?></option>
                                <option value="SD"><?php echo $countries['SD']; ?></option>
                                <option value="TN"><?php echo $countries['TN']; ?></option>
                                <option value="TR"><?php echo $countries['TR']; ?></option>
                                <option value="YE"><?php echo $countries['YE']; ?></option>
                                <option value="XX"><?php echo $this->lang->line('other'); ?></option>
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="marital-status"><?php echo $this->lang->line('marital_status'); ?></label>
                            <select id="marital-status" class="required form-control">
                                      <option value="Single"><?php echo $this->lang->line('single'); ?></option>
                                      <option value="Married"><?php echo $this->lang->line('married'); ?></option>
                                      <option value="Divorced"><?php echo $this->lang->line('divorced'); ?></option>
                                      <option value="Widowed"><?php echo $this->lang->line('widowed'); ?></option>
                                      <option value="Widowed"><?php echo $this->lang->line('non_specified'); ?></option>
                            </select>
                    </div>

					<div class="form-group">
						<label for="language"><?php echo $this->lang->line('language'); ?> *</label> 
						<select id="language" class="required form-control">
                            <option value="ar"><?php echo $languages['ar']; ?></option>
                            <option value="fa"><?php echo $languages['fa']; ?></option>
                            <option value="di"><?php echo $languages['di']; ?></option>
                            <option value="ur"><?php echo $languages['ur']; ?></option>
                            <option value="ps"><?php echo $languages['ps']; ?></option>
                            <option value="ku"><?php echo $languages['ku']; ?></option>
                            <option value="en"><?php echo $languages['en']; ?></option>
                            <option value="fr"><?php echo $languages['fr']; ?></option>
                            <option value="so"><?php echo $languages['so']; ?></option>
                            <option value="am"><?php echo $languages['am']; ?></option>
                            <option value="bn"><?php echo $languages['bn']; ?></option>
                            <option value="ti"><?php echo $languages['ti']; ?></option>
                            <option value="es"><?php echo $languages['es']; ?></option>
                            <option value="el"><?php echo $languages['el']; ?></option>
                            <option value="xx"><?php echo $this->lang->line('other'); ?></option>
						</select>
					</div>

					<div class="form-group">
                        <label for="notes"><?php echo $this->lang->line('notes'); ?></label>
                        <textarea id="notes" rows="4" class="form-control"></textarea>
                    </div>

                    <center><em id="form-message" class="text-error">
                        <?php echo $this->lang->line('fields_are_required'); ?></em></center>
                </div>

                <div class="col-md-5">
                    <h3><?php echo $this->lang->line('appointments'); ?></h3>
                    <div id="customer-appointments"></div>
                    <div id="appointment-details"></div>
                </div>
            </div>
    	</div>
    </div>
</div>
