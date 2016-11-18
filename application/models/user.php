<?php
class User extends CI_Model {
  function add_user($user){
    $query = "INSERT INTO users (name,alias, email, password,dob, created_at, updated_at) VALUES (?,?,?,?,?,NOW(), NOW())";
    $values = array($user['name'],$user['alias'],$user['email'],$user['password'], $user['dob']);
    $this->db->query($query, $values);
  }
  function find_by_email($email){
    $query = "SELECT * FROM users WHERE email=?";
    $values = array($email);
    return $this->db->query($query,$values)->row_array();
  }
  function get_users($user){
    $query = "SELECT * FROM users WHERE email != ?";
    $values = array($user);
    return $this->db->query($query,$values)->result_array();
  }
  function add_poke($user1, $user2){
    $checkquery = "SELECT * FROM pokes WHERE (user1=? AND user2=?)";
    $values = array($user1, $user2, $user2, $user1);
    $check = $this->db->query($checkquery, $values)->row_array();
    if (count($check)>0) {
      $query = "UPDATE pokes SET pokes = pokes+1 WHERE id=?";
      $values = array($check['id']);
      $this->db->query($query, $values);
      $this->db->query("UPDATE users SET poke_count = poke_count+1 WHERE id=?", array($user2));
    }else{
      $this->db->query("UPDATE users SET poke_count = poke_count+1 WHERE id=?", array($user2));
      $query = "INSERT INTO pokes (user1, user2, pokes, created_at, updated_at) VALUES (?,?,1,NOW(),NOW()) ";
      $values = array($user1, $user2);
      $this->db->query($query,$values);
    }
  }
  function poked_you($user){
    // $query1 = "SELECT DISTINCT users.alias, pokes.user1, pokes.user2,pokes.pokes FROM users JOIN pokes ON users.id=pokes.user2 WHERE pokes.user1 = ?";
    $values = array($user);
    // $firsthalf = $this->db->query($query1,$values)->result_array();
    $query = "SELECT DISTINCT users.alias, pokes.user1, pokes.user2,pokes.pokes FROM users JOIN pokes ON users.id=pokes.user1 WHERE pokes.user2 = ?";
    $secondhalf = $this->db->query($query,$values)->result_array();
    return $secondhalf;
  }
}
 ?>
