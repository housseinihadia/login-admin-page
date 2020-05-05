<?php 
require 'sqladd.php';
require 'conn.php';

class User extends sqladd{
	//set the table name
	private $_table = 'users';

	public function __construct(){
		// add from the database conn file
		global $config;

		//call the parent constructor
		parent::__construct($config);
	}
	/*
     list alll users
     @return array returns every user row as array of associative array
	*/
    public function getUsers(){
    	$this->select($this->_table);
    	return $this->ferchAll();
    } 
    /*
       show one user
       @param int user id
       @return array returns a user row as associative array
    */
    public function getUser($user_id){
    	$this->select($this->_table,'id='.$user_id);
    	return $this->fetch();
    }   
    /*
       add new user 
       @param array $user_data associative array containing column and vaule
       @ return int returns the id of the user inserted
    */
    public function addUser($user_data){
    	return $this->insert($this->_table,$user_data);
    }   
    /*
      update existing user
       @param array $user_data associative array containing column and vaule
      @ param int user_id
      @ return int number of affected rows
    */
    public function updateUser($user_data,$user_id){
    	return $this->update($this->_table,$user_data,'id=' .$user_id);
    }  
    /*
       delete existing user
       @ param int $user_id
       @ return int number of affected rows
    */
    public function deleteUser($user_id){
    	return $this->delete($this->_table,'id='.$user_id);
    }   
    /*
      search existing users
      @param string skyword
      @return array returns every user row as array of assciative arry containing colume value
    */
    public function searchUsers($keyword){
    	$this->select($this->_table,"name LIKE '%$skyword%' OR mail LIKE '%$skyword%'");
    	return $this->fetchAll();
    }  
}