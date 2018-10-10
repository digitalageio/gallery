<?php

class Table_crim_cred_logs extends Table
{

	public function insert($item)
	{
		// Fill in automatic values
		$item->created = date('Y-m-d H:i:s');
		$item->last_update = $item->created;
		
		$result = parent::insert($item);
		
		return $result;
	}
	

	public function update($item)
	{
		// Fill in automatic values
		$item->last_update = $item->created;
		
		$result = parent::update($item);
		
		return $result;
	}

    public function xmls_by_application($application_id){
        $xml_data_structs = $this->get(array(
            'where' => array("application_id = ? and xml IS NOT NULL", $application_id),
        ))->table;
        $rv = array();

        $rv[] = $xml_data_structs; //for testing purposes

        foreach($xml_data_structs as $data_struct){
            $rv[] = $data_struct;
        }
        return $rv;
    }
}
