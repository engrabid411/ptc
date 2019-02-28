<?php

class Login_model extends CI_Model {

        
        public function validateuser($username, $password, $role)
        {
                $this->db->where('username',$username);
                $this->db->where('password',$password);
                $this->db->where('role_id',$role);
                $this->db->limit(1);
                $query=$this->db->get('Users');
                $result=$query->result();
                $num_rows=$query->num_rows();
                if($num_rows > 0){
                        echo json_encode($result);
                }


         }

        
}