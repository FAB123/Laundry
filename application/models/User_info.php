
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Employee class
 */

class User_info extends Person
{
public function get_info($customer_id)
	{
		$this->db->from('people');
		$this->db->where('people.person_id', $customer_id);
		$query = $this->db->get();

		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $employee_id is NOT an employee
			$person_obj = parent::get_info(-1);

			//Get all the fields from employee table
			//append those fields to base parent object, we we have a complete empty object
			foreach($this->db->list_fields('people') as $field)
			{
				$person_obj->$field = '';
			}

			return $person_obj;
		}
	}
}