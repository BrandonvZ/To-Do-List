<?php
class Login_model extends CI_Model {

    // this function will get the specific user based on the email
    public function getUser($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $email);
        $this->db->limit(1);

        // get the user and return one
        $query = $this->db->get();
        return $query->row();
    }

    // this function will create the user based on the inputted data
    public function createUser($email)
    {
        // set the $email to username and store it in the $data variable
        $data = array ('username' => $email);

        // insert $data in the 'users' table
        $this->db->insert('users', $data);

        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);

        // get the user and return one
        $query = $this->db->get();
        return $query->row();
    }

    // this function will set the password for a new registred user
    public function setPassword($id, $encryptedPass)
    {
        // set the $encryptedPass to password in the 'users' table
        $this->db->set('password', $encryptedPass);
        $this->db->where('id', $id);
        $this->db->update('users');
    }

    // this function will get all users from 'users' table
    public function getUsers()
    {
        $this->db->select('*');
        $this->db->from('users');

        // get the user and return all users
        $query = $this->db->get();
        return $query->result();
    }

}
