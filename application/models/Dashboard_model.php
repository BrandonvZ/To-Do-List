<?php
class Dashboard_model extends CI_Model {

    public function getLists($user_id)
    {
        $this->db->select('*');
        $this->db->from('lists');
        $this->db->where('user_id', $user_id);

        $query = $this->db->get();
        return $query->result();
    }

    public function createList($id)
    {
        $data = array(
            'name' => 'List Title',
            'user_id' => $id
        );
        $this->db->insert('lists', $data);

        $this->db->select_max('id');
        $this->db->limit(1);

        $query = $this->db->get('lists');
        return $query->row();
    }

    public function deleteList($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('lists');
    }

    public function updateListTitle($id, $value)
    {
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('lists');
    }
}
