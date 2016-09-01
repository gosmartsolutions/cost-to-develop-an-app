<?php

class Email
{
    //@var instance of database class itself
    private $db = null;

    function __construct()
    {
        //Connect to database
        $this->db = Database::getInstance();
    }

    public function getTemplates($email_type)
    {
        //Gets email templates
		$query = "SELECT * FROM email_templates WHERE email_type = :email_type AND active = 1";
		$result = $this->db->select($query, array('email_type' => $email_type));
		return $result;
    }


    public function addLead($full_name, $user_email, $price_list)
	{
		$this->db->insert('users', array(
			"full_name" => $full_name,
			"email" => $user_email,
			"price_list" => $price_list,
			"date_added" => date("Y-m-d H:i:s")
		));
		echo 'success!';
	}

}
