<?php

namespace App\Models;

use CodeIgniter\Model;

class Home_model extends Model
{

    public function __construct()
    {

        $this->db = \Config\Database::connect();
    }

    public function select_data($table, $data, $where, $order_by = '', $order = '', $orWhere = '', $limit = '', $start = '')
    {

        $builder = $this->db->table($table);
        $builder->select($data);
        if ($where) {
            $builder->where($where);
        }
        if ($orWhere) {
            $builder->orWhere($orWhere);
        }
        if ($order_by) {
            $builder->orderBy($order_by, $order);
        }
        if ($limit != '' && empty($start)) {
            $builder->limit($limit);
        } else if ($limit != '' && $start != '') {
            $builder->limit($limit, $start);
        }
        $query = $builder->get()->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
        return true;
    } // select data
    public function select_value($table, $data, $where, $order_by = '', $order = '')
    {
        $builder = $this->db->table($table);
        $builder->select($data);
        if ($where) {
            $builder->where($where);
        }
        $query = $builder->get()->getResult();
        if ($order) {
            $builder->order_by($order_by, $order);
        }
        if (($query)) {
            return $query[0]->$data;
        } else {
            return false;
        }
        return true;
    } // select Value

    public function select_data_distinct($table, $data, $where, $order_by = '', $order = '', $orWhere = '', $limit = '', $start = '')
    {

        $builder = $this->db->table($table);
        $builder->distinct();
        $builder->select($data);

        if ($where) {
            $builder->where($where);
        }
        if ($orWhere) {
            $builder->orWhere($orWhere);
        }
        if ($order_by) {
            $builder->orderBy($order_by, $order);
        }
        if ($limit != '' && empty($start)) {
            $builder->limit($limit);
        } else if ($limit != '' && $start != '') {
            $builder->limit($limit, $start);
        }
        $query = $builder->get()->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
        return true;
    } // select data

    public function select_data_join($table, $data, $where,  $joinTable, $joinWhere)
    {

        $builder = $this->db->table($table);
        $builder->select($data);

        $builder->join($joinTable, $joinWhere);
        if ($where) {
            $builder->where($where);
        }

        $query = $builder->get()->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
        return true;
    } // select data Join


    public function select_product_attriubtes($id)
    {

        // $query = "SELECT   p.*, p.price as product_price, a.*, a.price as a_price, pa.* 
        // FROM product p
        //  JOIN product_attributes pa ON p.product_id = pa.product_id
        //  JOIN attributes a ON pa.attribute_id = a.attribute_id
        // WHERE p.product_id = '$id'

        // ";
        $query = "SELECT a.*, a.price as attribute_price, pa.* 
        FROM attributes  a
        INNER JOIN product_attributes pa ON a.attribute_id = pa.attribute_id
        WHERE  pa.product_id = '$id'
       
        ";

        $query = $this->db->query($query);
        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function select_product_attributes_categorie($id)
    {

        $query = "SELECT ac.*  
        FROM attributes_categorie  ac
        INNER JOIN product_attributes_categorie pac ON ac.attribute_categorie_id = pac.attribute_categorie_id
        WHERE  pac.product_id = '$id'
       
        ";

        $query = $this->db->query($query);
        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }


    public function select_attributes_price($attributes_ids)
    {

        $query = "SELECT attribute_id, price
           FROM attributes 
           WHERE attribute_id IN ($attributes_ids) ";

        $query = $this->db->query($query);

        $query = $query->getResult();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    public function select_data_wishlist($chef_id)
    {


        $query = "SELECT u.user_id, u.name, u.email, u.phone, u.avatar, u.feature_image, u.gender, u.dob, u.state, u.rating, 
        chef_metadata.hourly_rate, chef_metadata.cuisine_experience, chef_metadata.total_experience, chef_metadata.awards, chef_metadata.business_hours,
        wishlist_id
        FROM user u
        INNER JOIN chef_metadata ON u.user_id = chef_metadata.user_id
        INNER JOIN wishlist ON u.user_id = wishlist.chef_id
        WHERE role = 1 AND is_active = 2 AND u.user_id IN ('$chef_id') ORDER BY wishlist_id DESC ";


        $query = $this->db->query($query);

        $query = $query->getResult();




        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function save_data($table, $data)
    {
        $builder = $this->db->table($table);
        $builder->insert($data);
        return true;
    } // save Data
    public function save_data_batch($table, $data)
    {
        $builder = $this->db->table($table);
        $builder->insertBatch($data);
        return true;
    } // save Data

    public function update_data($table, $data, $where)
    {
        $builder = $this->db->table($table);
        $builder->where($where);
        $update =  $builder->update($data);
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    public function update_data_batch($table, $data, $where)
    {
        $builder = $this->db->table($table);
        $builder->updateBatch($data, $where);
        return true;
    }

    public function delete_data($table, $where)
    {
        $delete = false;
        $builder = $this->db->table($table);
        $builder->where($where);
        $delete = $builder->delete();
        if ($delete) {
            return true;
        } else {
            return false;
        }
    }
}
