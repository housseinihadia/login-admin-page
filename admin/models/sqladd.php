<?php
class mysqladapter{
	protected $_config=array();
	protected $_link;
	protected $_result;

	/**
      constructor

	*/
  public function _construct(array_config){
  	if(count($config)!==4){
  		throw new InvalidArgumentException('Invalid numberof connection parameters.');
  	}
  	$this->_config=$config;
  }    
  /*
   * connect to mysql
  */

  public function connect(){
  	//connect only once 
  	if($this-> link === null){
       list($host,$user,$password,$database)=$this->_config;
       if(!$this-> link = @mysqli_connect($host,$user,$password,$database)){
       	throw new RuntimeException("Error connection to the server :" . mysqli_connect_error());
       	
       }
       unset($host,$user,$password,$database);
  	}
  	return $this->_link;
  }
  /*
    Execute the specified query
  */
  public function query($query){
  	if(!is_string($query) || empty($query)){
  		throw new InvalidArgumentException("The specified query is not valid.");	
  	}
  	// lazy conect to my sql
  	$this->connect();
  	if(!$this->_result=mysqli_query($this->_link,$query)){
  		throw new RuntimeException("Error executing the specified query" .$query . mysqli_error($this->_link));
  	}
  	return $this->_result;
  }  
  /*
   perform a select statment
  */
  public function select($table,$where='',$fields='+',$order='',$limit=null,$offset=null){
  	$query='SELECT'. $fields . ' FROM ' .$table .(($where) ? ' WHERE ' .$where : '') .(($limit) ? . 'LIMIT' . $limit : '') .(($offset && $limit) ? ' OFFSET ' . $offset : '') . (($order) ? ' ORDER BY ' . $order : '');
  	$this->query($query);
  	return $this->countRows();
  } 
  /*
    perform a insert statment
  */
  public function insert($table,array $data ){
  	$fields= implode(',',array_keys($data));
  	$values= implode(',', array_map(array($this,'quotevalue'), array_values($data)));
  	$query='INSERT INTO' . $table . '(' .$fields . ')' .'VALUES (' .$values . ')';
  	$this->query($query);
  	return $this->getInsertId();
  }  
  /*
    perform a update statement
  */
  public function update($table,array $data ,$where='') {
    $set = array();
    foreach ($data as $fields => $value) {
    	$set[]=$fields . '=' . $this->quotevalue($value);
    }
    $set = implode(',', $set);
    $query = 'UPDATE' . $table . 'SET' .$set . (($where) ? 'WHERE' . $where : '');
    $this->query($query);
    return $this->getAffectedRows();
  } 
  /*
    preform a delete statment
  */
  public function delete($table,$where=''){
  	$query='DELETE FROM ' . $table .(($where) ? 'WHERE' .$where : '');
  	$this->query($query);
  	return $this->getAffectedRows();
  }  
  /*
    escape the specified value
  */
    public function quotevalue($value){
    	$this->connect();
    	if ($value === null){
    		$value = 'NNLL';
    	}elseif (!is_numeric($value)){
          $value="'" . mysqli_real_escape_string($this->_link,$value) . "'";
    	}
         return $value;
    } 
      /* fetch a single row from the current result set( as an associative array)*/
    public function fetch(){
    	if($this->_result !== null){
    		if(($row = myssqli_fetch_array($this->_result,MYSQLI_ASSOC))=== false){
    			$this->freeResult();
    		}
    		return $row;
    	}
    	return false;
    }
    /*
       fetch all row from the current result set( as an associative arrays)
    */
    public function fetchAll(){
    	if($this->_result !== null){
    		if(($all = mysqli_fetch_all($this->_result,MYSQLI_ASSOC)) === false){
    			$this->freeResult();
    		}
    		return $all;
    	}
    	    return false;
    }   
    /*
      get the insertion ID
    */
    public function getInsertId(){
    	return $this->_link !== null 
    	? mysqli_insert_id($this->_link) : null;
    }  
    /*
       get the number of rows returned by the current result set
    */
    public function countRows(){
    	return $this->_result !== null 
    	? mysqli_num_rows($this->_result) : 0;
    }   
    /*
       get the number of affectwd rows
    */
    public function getAffectedRows(){
    	return $this->_link !== null 
    	? mysqli_affected_rows($this->_link) : 0;
    }   
    /*
     free up the current result set
    */
    public function freeResult(){
    	if($this->_result === null){
    		return false;
    	}
    	mysqli_free_result($this->_result);
    	return true;
    } 
    /*
      close explitly the database connection
    */
    public function disconnect(){
    	if($this->_link===null){
    		return false;
    	}
    	mysqli_close($this->_link);
    	$this->_link=null;
    	return true;
    }  
    /*
       close automatcally the database connecthion when the instance of the class is 
    */
    public function __destruct(){
       $this->disconnect();
    }   
}