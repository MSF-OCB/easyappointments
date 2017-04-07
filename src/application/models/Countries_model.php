<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Svetoslav Mutev
 */
class Countries_model extends CI_Model
{
	public $translationPrefix = 'country_code_';

	public function getTranslationNameByCode($code)
	{
		return strtolower($this->translationPrefix . $code);
	}

	public function getAllForList()
	{
		$all = $this->db->get('ea_countries')->result_array();
		$results = array();
		foreach($all as $country) {
			$results[$country['country_code']] = $country['country_name'];
		}

		return $results;
	}

}