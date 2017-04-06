/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2016, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

window.BackendReports = window.BackendReports || {};

/**
 * Backend Reports
 *
 * This namespace handles the js functionality of the backend services page.
 *
 * @module BackendReports
 */
(function(exports) {

    'use strict';

    /**
     * Contains the basic record methods for the page.
     *
     * @type {ServicesHelper|CategoriesHelper}
     */
    var helper;

    var servicesHelper = new ReportsHelper();

    /**
     * Default initialize method of the page.
     *
     * @param {Boolean} bindEventHandlers Optional (true), determines whether to bind the  default event handlers.
     */
    exports.initialize =  function(bindEventHandlers) {
        bindEventHandlers = bindEventHandlers || true;

    };

})(window.BackendReports);
