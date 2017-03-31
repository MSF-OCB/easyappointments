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
                                        <option value="AF">Afghanistan</option>
                                        <option value="DZ">Algeria</option>
                                        <option value="BD">Bangladesh</option>
                                        <option value="BF">Burkina Faso</option>
                                        <option value="CM">Cameroon</option>
                                        <option value="CF">Central African Republic</option>
                                        <option value="TD">Chad</option>
                                        <option value="CG">Congo</option>
                                        <option value="CD">Democratic Republic of Congo</option>
                                        <option value="DO">Dominican Republic</option>
                                        <option value="EG">Egypt</option>
                                        <option value="ER">Eritrea</option>
                                        <option value="ET">Ethiopia</option>
                                        <option value="GM">Gambia</option>
                                        <option value="GH">Ghana</option>
                                        <option value="GW">Guinea Bissau</option>
                                        <option value="GN">Guinea Conakry</option>
                                        <option value="IN">India</option>
                                        <option value="IQ">Iraq</option>
                                        <option value="IR">Iran</option>
                                        <option value="IV">Ivory coast</option>
                                        <option value="LB">Lebanon</option>
                                        <option value="LY">Libya</option>
                                        <option value="ML">Mali</option>
                                        <option value="MA">Morocco</option>
                                        <option value="MM">Myanmar</option>
                                        <option value="NP">Nepal</option>
                                        <option value="NE">Niger</option>
                                        <option value="NG">Nigeria</option>
                                        <option value="PK">Pakistan</option>
                                        <option value="PY">Palestinian living in Syria</option>
                                        <option value="PX">Palestinian territories</option>
                                        <option value="SN">Senegal</option>
                                        <option value="RS">Serbia</option>
                                        <option value="SO">Somalia</option>
                                        <option value="SY">Syria</option>
                                        <option value="SD">Sudan</option>
                                        <option value="TN">Tunisia</option>
                                        <option value="TR">Turkey</option>
                                        <option value="YE">Yemen</option>
                                        <option value=""><?php echo $this->lang->line('other'); ?>
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
                                        <option value="AR">Arabic</option>
                                        <option value="FA">Farsi</option>
                                        <option value="DA">Dari</option>
                                        <option value="UR">Urdu</option>
                                        <option value="PS">Pashto</option>
                                        <option value="KU">Kurdish</option>
                                        <option value="EN">English</option>
                                        <option value="FR">French</option>
                                        <option value="SO">Somali</option>
                                        <option value="AM">Amharic</option>
                                        <option value="BN">Bengali</option>
                                        <option value="TI">Tigrinya</option>
                                        <option value="ES">Spanish</option>
                                        <option value="EL">Greek</option>
                                        <option value="XX">Other</option>
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
