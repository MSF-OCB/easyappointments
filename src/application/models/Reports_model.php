<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * Reports Model
 *
 * @package Models
 */
class Reports_model extends CI_Model
{

	public function getAll()
	{
		return $this->db->query('
                        SELECT distinct ap.start_datetime start, IFNULL(sc.name, \'\') category_name, se.name service_name, CONCAT(us.first_name, \' \', us.last_name) provider_name,
				CONCAT(cu.first_name, \' \', cu.last_name) customer_name, cu.gender, cu.address, cu.phone_number_1,
				cu.country_origin, cu.language, (IF(ap.end_datetime < NOW(), ( IF(ap.no_show > 0, \'No Show\', \'Seen\')), \'Scheduled\')) as status
			FROM ea_appointments ap
				INNER JOIN ea_services se ON ap.id_services = se.id
				INNER JOIN ea_services_providers sp ON ap.id_services = sp.id_services
				LEFT JOIN ea_service_categories sc ON se.id_service_categories = sc.id
				INNER JOIN ea_customers cu ON ap.id_users_customer = cu.id
				INNER JOIN ea_users us ON ap.id_users_provider = us.id ')
		->result();
	}
}
