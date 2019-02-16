<?php
class Login_model extends CI_Model {

    public function getUser($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username', $email);
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    public function createUser($email)
    {
        $data = array ('username' => $email);
        $this->db->insert('users', $data);

        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    public function setPassword($id, $encryptedPass)
    {
        $this->db->set('password', $encryptedPass);
        $this->db->where('id', $id);
        $this->db->update('users');
    }

}
