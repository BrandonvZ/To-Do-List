<?php
class Dashboard_model extends CI_Model {

    // this function will get all lists based on the user
    public function getLists($user_id)
    {
        $this->db->select('*');
        $this->db->from('lists');
        $this->db->where('user_id', $user_id);

        // get all lists and return all
        $query = $this->db->get();
        return $query->result();
    }

    // this function will create a list based on the user
    public function createList($id)
    {
        // set the name to List Title and $id to user_id and store it in the $data variable
        $data = array(
            'name' => 'List Title',
            'user_id' => $id
        );

        // insert $data in the 'lists' table
        $this->db->insert('lists', $data);

        $this->db->select_max('id');
        $this->db->limit(1);

        // get the list and return one
        $query = $this->db->get('lists');
        return $query->row();
    }

    // this function will delete all lists and its items based on the id
    public function deleteList($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('lists');

        $this->db->where('list_id', $id);
        $this->db->delete('items');
    }

    // this function will get all items based on the list_id
    public function getItems($list_id)
    {
        $this->db->select('*');
        $this->db->from('items');
        $this->db->where('list_id', $list_id);

        // get all items and return all
        $query = $this->db->get();
        return $query->result();
    }

    // this function will update the list name based on the id and the inputted value
    public function updateListTitle($id, $value)
    {
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('lists');
    }

    // this function will update the completion of an item based on the id and inputted value
    public function acceptListItem($id, $value)
    {
        $this->db->set('done', $value);
        $this->db->where('id', $id);
        $this->db->update('items');
    }

    // this function will create an item for a list based on the id
    public function createListItem($id)
    {
        // set the list_id to $id, name to Item Name and done to 0 and store it in the $data variable
        $data = array(
            'list_id' => $id,
            'name' => 'Item Name',
            'done' => 0
        );

        // insert $data in the 'items' table
        $this->db->insert('items', $data);

        $this->db->select_max('id');
        $this->db->limit(1);

        // get the item and return one
        $query = $this->db->get('items');
        return $query->row();
    }

    // this function will update the item name based on the id and inputted value
    public function updateListItem($id, $value)
    {
        $this->db->set('name', $value);
        $this->db->where('id', $id);
        $this->db->update('items');
    }

    // this function will update the item duration based on the id and inputted value
    public function updateListItemTime($id, $value)
    {
        $this->db->set('duration', $value);
        $this->db->where('id', $id);
        $this->db->update('items');
    }

    // this function will delete an item based on the id
    public function deleteListItem($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('items');
    }

    // this function will delete an user based on the id (admin functionality)
    public function deleteUser($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }
}
