<?php
require_once 'interfaces/FolderInterface.php';
class Folder implements FolderInterface{
	public $_folderName=NULL;
	public $_folderCreatedTime=NULL;
	public $_folderPath=NULL;

	
  /**
   * @return string
   */
  public function __construct($folderPath=NULL) {
  	if(!empty($folderPath)){
		$this->setPath($folderPath);
	}
		
  } 
  public function getName(){
  	return $this->_folderName;
  }
  
  
  public function setName($name){
  	if(!empty($name)){
		$this->_folderName=$name;
	}else{
		exit(FOLDER_NAME_REQUIRED);
	}
  }

  /**
   * @return DateTime
   */
  public function getCreatedTime(){
  	return $this->_folderCreatedTime;
  }
  public function setCreatedTime($created){
  	if(!empty($created)){
		$this->_folderCreatedTime=$created;
	}else{
		exit(CREATED_TIME_REQUIRED);
	}
  }
  public function getPath(){
  	return $this->_folderPath;
  }
  /**
   * @param string $path
   *
   * @return $this
   */
  public function setPath($path){
  	if(!empty($path)){
		$this->_folderPath=$path;
	}else{
		exit(FOLDER_PATH_REQUIRED);
	}
  }
}
