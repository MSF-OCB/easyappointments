<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      Manuel Silva Gallego <manuel.silva.gallego@brussels.msf.org>
 * @copyright   Copyright (c) 2013 - 2016, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

// Load Twilio API.
require_once __DIR__ . '/external/twilio-php/Twilio/autoload.php';

// Use the REST API Client to make requests to the Twilio REST API
use Twilio\Rest\Client;

/**
 * Twilio SMS Class
 *
 *
 * @package Libraries
 */
class Twilio_SMS {
    /**
     * CodeIgniter Instance
     *
     * @var CodeIgniter
     */
    protected $CI;

    /**
     * Twilio API Client
     *
     * @var Twilio_client
     *
     */
    protected $client;

    /**
     * Twilio account sid
     *
     * @var Twilio_sid
     */
    protected $sid;

    /**
     * Twilio account sid
     *
     * @var Twilio_token
     */
    protected $token;
    
    /**
     * Class Constructor
     *
     * This method initializes the Twilio client class
     */
    public function __construct() {
        $this->CI =& get_instance();

        if (!isset($_SESSION)) {
            @session_start();
        }

        // Your Account SID and Auth Token from twilio.com/console
        $this->sid = 'ACe357f1873c9c7e56c423caaa47bd8180';
        $this->token = '59c7f6c846a88e0d4e98e4d6fb84c74c';
        $this->client = new Client($this->sid, $this->token);
    }

    /**
     * Send sms from standard phone number chosen at Twilio .
     *
     */
    public function send_sms($to_phone, $sms_text) {
        /*$this->client->messages->create(
                // the number you'd like to send the message to
                '+' . $to_phone, array(
            // A Twilio phone number you purchased at twilio.com/console
            'from' => '+32460200286',
            // the body of the text message you'd like to send
            'body' => $sms_text
                )
        );Disabled for now*/
        log_message('debug', "Message to " . $to_phone . " sent");
    }

}

/* End of file twilio_sms.php */
/* Location: ./application/libraries/twilio_sms.php */
