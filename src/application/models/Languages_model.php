<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Svetoslav Mutev
 */
class Languages_model extends CI_Model
{
	public $translationPrefix = 'language_code_';

	public function getTranslationNameByCode($code)
	{
		return strtolower($this->translationPrefix . $code);
	}

	public function getAllForList()
	{
		$all = $this->db->get('ea_languages')->result_array();
		$results = array();
		foreach($all as $country) {
			$results[$country['code']] = $country['language'];
		}

		return $results;
	}

}