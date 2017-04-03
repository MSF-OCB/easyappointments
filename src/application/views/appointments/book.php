<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#35A768">
    <title><?php echo $this->lang->line('page_title') . ' ' .  $company_name; ?></title>

    <?php
        // ------------------------------------------------------------
        // INCLUDE CSS FILES
        // ------------------------------------------------------------ ?>

    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo base_url('assets/ext/bootstrap/css/bootstrap.min.css'); ?>">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo base_url('assets/ext/jquery-ui/jquery-ui.min.css'); ?>">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo base_url('assets/ext/jquery-qtip/jquery.qtip.min.css'); ?>">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo base_url('assets/css/frontend.css'); ?>">
    <link
        rel="stylesheet"
        type="text/css"
        href="<?php echo base_url('assets/css/general.css'); ?>">

    <?php
        // ------------------------------------------------------------
        // WEBPAGE FAVICON
        // ------------------------------------------------------------ ?>

    <link rel="icon" type="image/x-icon"
            href="<?php echo base_url('assets/img/favicon.ico'); ?>">

    <link rel="icon" sizes="192x192"
            href="<?php echo base_url('assets/img/logo.png'); ?>">
</head>

<body>
    <div id="main" class="container">
        <div class="wrapper row">
            <div id="book-appointment-wizard" class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">

                <?php
                    // ------------------------------------------------------
                    // FRAME TOP BAR
                    // ------------------------------------------------------ ?>

                <div id="header">
                    <span id="company-name"><?php echo $company_name; ?></span>

                    <div id="steps">
                        <div id="step-1" class="book-step active-step" title="<?php echo $this->lang->line('step_one_title'); ?>">
                            <strong>1</strong>
                        </div>

                        <div id="step-2" class="book-step" title="<?php echo $this->lang->line('step_two_title'); ?>">
                            <strong>2</strong>
                        </div>
                        <div id="step-3" class="book-step" title="<?php echo $this->lang->line('step_three_title'); ?>">
                            <strong>3</strong>
                        </div>
                        <div id="step-4" class="book-step" title="<?php echo $this->lang->line('step_four_title'); ?>">
                            <strong>4</strong>
                        </div>
                    </div>
                </div>

                <?php
                    // ------------------------------------------------------
                    // CANCEL APPOINTMENT BUTTON
                    // ------------------------------------------------------
                    if ($manage_mode === TRUE) {
                        echo '
                            <div id="cancel-appointment-frame" class="row">
                                <div class="col-xs-12 col-sm-10">
                                    <p>' .
                                        $this->lang->line('cancel_appointment_hint') .
                                    '</p>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <form id="cancel-appointment-form" method="post"
                                            action="' . site_url('appointments/cancel/' . $appointment_data['hash']) . '">
                                        <input type="hidden" name="csrfToken" value="' . $this->security->get_csrf_hash() . '" />
                                        <textarea name="cancel_reason" style="display:none"></textarea>
                                        <button id="cancel-appointment" class="btn btn-default">' .
                                                $this->lang->line('cancel') . '</button>
                                    </form>
                                </div>
                            </div>';
                    }
                ?>

                <?php
                    // ------------------------------------------------------
                    // DISPLAY EXCEPTIONS (IF ANY)
                    // ------------------------------------------------------
                    if (isset($exceptions)) {
                        echo '<div style="margin: 10px">';
                        echo '<h4>' . $this->lang->line('unexpected_issues') . '</h4>';
                        foreach($exceptions as $exception) {
                            echo exceptionToHtml($exception);
                        }
                        echo '</div>';
                    }
                ?>

                <?php
                    // ------------------------------------------------------
                    // SELECT SERVICE AND PROVIDER
                    // ------------------------------------------------------ ?>

                <div id="wizard-frame-1" class="wizard-frame">
                    <div class="frame-container">
                        <h3 class="frame-title"><?php echo $this->lang->line('step_one_title'); ?></h3>

                        <div class="frame-content">
                            <div class="form-group">
                                <label for="select-service">
                                    <strong><?php echo $this->lang->line('select_service'); ?></strong>
                                </label>

                                <select id="select-service" class="col-md-4 form-control">
                                    <?php
                                        // Group services by category, only if there is at least one service
                                        // with a parent category.
                                        $has_category = FALSE;
                                        foreach($available_services as $service) {
                                            if ($service['category_id'] != NULL) {
                                                $has_category = TRUE;
                                                break;
                                            }
                                        }

                                        if ($has_category) {
                                            $grouped_services = array();

                                            foreach($available_services as $service) {
                                                if ($service['category_id'] != NULL) {
                                                    if (!isset($grouped_services[$service['category_name']])) {
                                                        $grouped_services[$service['category_name']] = array();
                                                    }

                                                    $grouped_services[$service['category_name']][] = $service;
                                                }
                                            }

                                            // We need the uncategorized services at the end of the list so
                                            // we will use another iteration only for the uncategorized services.
                                            $grouped_services['uncategorized'] = array();
                                            foreach($available_services as $service) {
                                                if ($service['category_id'] == NULL) {
                                                    $grouped_services['uncategorized'][] = $service;
                                                }
                                            }

                                            foreach($grouped_services as $key => $group) {
                                                $group_label = ($key != 'uncategorized')
                                                        ? $group[0]['category_name'] : 'Uncategorized';

                                                if (count($group) > 0) {
                                                    echo '<optgroup label="' . $group_label . '">';
                                                    foreach($group as $service) {
                                                        echo '<option value="' . $service['id'] . '">'
                                                            . $service['name'] . '</option>';
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                        }  else {
                                            foreach($available_services as $service) {
                                                echo '<option value="' . $service['id'] . '">'
                                                            . $service['name'] . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="select-provider">
                                    <strong><?php echo $this->lang->line('select_provider'); ?></strong>
                                </label>

                                <select id="select-provider" class="col-md-4 form-control"></select>
                            </div>

                            <div id="service-description" style="display:none;"></div>
                        </div>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-next-1" class="btn button-next btn-primary"
                                data-step_index="1">
                            <?php echo $this->lang->line('next'); ?>
                            <span class="glyphicon glyphicon-forward"></span>
                        </button>
                    </div>
                </div>

                <?php
                    // ------------------------------------------------------
                    // SELECT APPOINTMENT DATE
                    // ------------------------------------------------------ ?>

                <div id="wizard-frame-2" class="wizard-frame" style="display:none;">
                    <div class="frame-container">

                        <h3 class="frame-title"><?php echo $this->lang->line('step_two_title'); ?></h3>

                        <div class="frame-content row">
                            <div class="col-xs-12 col-sm-6">
                                <div id="select-date"></div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <?php // Available hours are going to be fetched via ajax call. ?>
                                <div id="available-hours"></div>
                            </div>
                        </div>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-back-2" class="btn button-back btn-default"
                                data-step_index="2">
                            <span class="glyphicon glyphicon-backward"></span>
                            <?php echo $this->lang->line('back'); ?>
                        </button>
                        <button type="button" id="button-next-2" class="btn button-next btn-primary"
                                data-step_index="2">
                            <?php echo $this->lang->line('next'); ?>
                            <span class="glyphicon glyphicon-forward"></span>
                        </button>
                    </div>
                </div>

                <?php
                    // ------------------------------------------------------
                    // ENTER CUSTOMER DATA
                    // ------------------------------------------------------ ?>

                <div id="wizard-frame-3" class="wizard-frame" style="display:none;">
                    <div class="frame-container">

                        <h3 class="frame-title"><?php echo $this->lang->line('step_three_title'); ?></h3>

                        <div class="frame-content row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="first-name" class="control-label"><?php echo $this->lang->line('first_name'); ?> *</label>
                                    <input type="text" id="first-name" class="required form-control" maxlength="100" />
                                </div>
                                <div class="form-group">
                                    <label for="last-name" class="control-label"><?php echo $this->lang->line('last_name'); ?> *</label>
                                    <input type="text" id="last-name" class="required form-control" maxlength="250" />
                                </div>
                                <div class="form-group">
                                    <label for="gender" class="control-label"><?php echo $this->lang->line('gender'); ?> *</label>
                                    <!-- input list="gender" class="required form-control" maxlength="5" /-->
                                    <select id="gender" class="required form-control">
                                      <option value="M"><?php echo $this->lang->line('male'); ?></option>
                                      <option value="F"><?php echo $this->lang->line('female'); ?></option>
                                      <option value="O"><?php echo $this->lang->line('other'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="control-label"><?php echo $this->lang->line('email'); ?></label>
                                    <input type="text" id="email" class="form-control" maxlength="250" />
                                </div>
                                <div class="form-group">
                                    <label for="phone-number-1" class="control-label"><?php echo $this->lang->line('phone_number_1'); ?> *</label>
                                    <input type="text" id="phone-number-1" class="required form-control" maxlength="60" />
                                </div>
                                <div class="form-group">
                                    <label for="phone-number-2" class="control-label"><?php echo $this->lang->line('phone_number_2'); ?></label>
                                    <input type="text" id="phone-number-2" class="form-control" maxlength="60" />
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label for="address" class="control-label"><?php echo $this->lang->line('address'); ?> *</label>
                                    <input type="text" id="address" class="required form-control" maxlength="250" />
                                </div>
                                <div class="form-group">
                                    <label for="country" class="control-label"><?php echo $this->lang->line('country_origin'); ?> *</label>
                                    <!-- input type="text" id="country" class="required form-control" maxlength="120" /-->
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
                                    <label for="marital-status" class="control-label"><?php echo $this->lang->line('marital_status'); ?> *</label>
                                    <!-- input type="text" id="marital-status" class="form-control" maxlength="120" /-->
                                    <select id="marital-status" class="required form-control">
                                      <option value="Single"><?php echo $this->lang->line('single'); ?></option>
                                      <option value="Married"><?php echo $this->lang->line('married'); ?></option>
                                      <option value="Divorced"><?php echo $this->lang->line('divorced'); ?></option>
                                      <option value="Widowed"><?php echo $this->lang->line('widowed'); ?></option>
                                      <option value="Widowed"><?php echo $this->lang->line('non_specified'); ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="language" class="control-label"><?php echo $this->lang->line('language'); ?> *</label>
                                    <!-- input type="text" id="language" class="required form-control" maxlength="120" /-->
                                    <select id="language" class="required form-control">
                                        <option value="ar">Arabic</option>
                                        <option value="fa">Farsi</option>
                                        <option value="di">Dari</option>
                                        <option value="ur">Urdu</option>
                                        <option value="ps">Pashto</option>
                                        <option value="ku">Kurdish</option>
                                        <option value="en">English</option>
                                        <option value="fr">French</option>
                                        <option value="so">Somali</option>
                                        <option value="am">Amharic</option>
                                        <option value="bn">Bengali</option>
                                        <option value="ti">Tigrinya</option>
                                        <option value="es">Spanish</option>
                                        <option value="el">Greek</option>
                                        <option value="xx">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="notes" class="control-label"><?php echo $this->lang->line('notes'); ?></label>
                                    <textarea id="notes" maxlength="500" class="form-control" rows="3"></textarea>
                                </div>
                            </div>

                            <em id="form-message" class="text-danger"><?php echo $this->lang->line('fields_are_required'); ?></em>
                        </div>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-back-3" class="btn button-back btn-default"
                                data-step_index="3"><span class="glyphicon glyphicon-backward"></span>
                            <?php echo $this->lang->line('back'); ?>
                        </button>
                        <button type="button" id="button-next-3" class="btn button-next btn-primary"
                                data-step_index="3">
                            <?php echo $this->lang->line('next'); ?>
                            <span class="glyphicon glyphicon-forward"></span>
                        </button>
                    </div>
                </div>

                <?php
                    // ------------------------------------------------------
                    // APPOINTMENT DATA CONFIRMATION
                    // ------------------------------------------------------ ?>

                <div id="wizard-frame-4" class="wizard-frame" style="display:none;">
                    <div class="frame-container">
                        <h3 class="frame-title"><?php echo $this->lang->line('step_four_title'); ?></h3>
                        <div class="frame-content row">
                            <div id="appointment-details" class="col-xs-12 col-sm-6"></div>
                            <div id="customer-details" class="col-xs-12 col-sm-6"></div>
                        </div>
                        <?php if ($this->settings_model->get_setting('require_captcha') === '1'): ?>
                        <div class="frame-content row">
                            <div class="col-sm-12 col-md-6">
                                <h4 class="captcha-title">
                                    CAPTCHA
                                    <small class="glyphicon glyphicon-refresh"></small>
                                </h4>
                                <img class="captcha-image" src="<?php echo site_url('captcha'); ?>">
                                <input class="captcha-text" type="text" value="" />
                                <span id="captcha-hint" class="help-block" style="opacity:0">&nbsp;</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-back-4" class="btn button-back btn-default"
                                data-step_index="4">
                            <span class="glyphicon glyphicon-backward"></span>
                            <?php echo $this->lang->line('back'); ?>
                        </button>
                        <form id="book-appointment-form" style="display:inline-block" method="post">
                            <button id="book-appointment-submit" type="button" class="btn btn-success">
                                <span class="glyphicon glyphicon-ok"></span>
                                <?php
                                    echo (!$manage_mode) ? $this->lang->line('confirm')
                                            : $this->lang->line('update');
                                ?>
                            </button>
                            <input type="hidden" name="csrfToken" />
                            <input type="hidden" name="post_data" />
                        </form>
                    </div>
                </div>

                <?php
                    // ------------------------------------------------------
                    // FRAME FOOTER
                    // ------------------------------------------------------ ?>

                <div id="frame-footer">
                    Powered By
                    <a href="http://easyappointments.org" target="_blank">Easy!Appointments</a>
                    |
                    <span id="select-language" class="label label-success">
    		        	<?php echo ucfirst($this->config->item('language')); ?>
    		        </span>
                    |
                    <a href="<?php echo site_url('backend'); ?>">
                        <?php echo $this->session->userdata('user_id')
                            ? $this->lang->line('backend_section') 
                            : $this->lang->line('login'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
        // ------------------------------------------------------------
        // GLOBAL JAVASCRIPT VARIABLES
        // ------------------------------------------------------------ ?>

    <script type="text/javascript">
        var GlobalVariables = {
            availableServices   : <?php echo json_encode($available_services); ?>,
            availableProviders  : <?php echo json_encode($available_providers); ?>,
            baseUrl             : <?php echo json_encode($this->config->item('base_url')); ?>,
            manageMode          : <?php echo ($manage_mode) ? 'true' : 'false'; ?>,
            dateFormat          : <?php echo json_encode($date_format); ?>,
            appointmentData     : <?php echo json_encode($appointment_data); ?>,
            providerData        : <?php echo json_encode($provider_data); ?>,
            customerData        : <?php echo json_encode($customer_data); ?>,
            csrfToken           : <?php echo json_encode($this->security->get_csrf_hash()); ?>
        };

        var EALang = <?php echo json_encode($this->lang->language); ?>;
        var availableLanguages = <?php echo json_encode($this->config->item('available_languages')); ?>;
    </script>

    <?php
        // ------------------------------------------------------------
        // INCLUDE JAVASCRIPT FILES
        // ------------------------------------------------------------ ?>

    <script
        type="text/javascript"
        src="<?php echo base_url('assets/js/general_functions.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/ext/jquery/jquery.min.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/ext/jquery-ui/jquery-ui.min.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/ext/jquery-qtip/jquery.qtip.min.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/ext/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/ext/datejs/date.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/js/frontend_book_api.js'); ?>"></script>
    <script
        type="text/javascript"
        src="<?php echo base_url('assets/js/frontend_book.js'); ?>"></script>

    <?php
        // ------------------------------------------------------------
        // VIEW FILE JAVASCRIPT CODE
        // ------------------------------------------------------------ ?>

    <script type="text/javascript">
    $(document).ready(function() {
            FrontendBook.initialize(true, GlobalVariables.manageMode);
            GeneralFunctions.enableLanguageSelection($('#select-language'));
        });
    </script>

    <?php google_analytics_script(); ?>
</body>
</html>
