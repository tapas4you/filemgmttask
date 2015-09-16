<?php

require_once 'interfaces/FileInterface.php';
class File extends Folder implements FileInterface{
public $_size=0;
  /**
   * @return string
   */
   public function __construct($filePath=NULL) {
  	if(!empty($filePath)){
		$this->setPath($filePath);
	}
		
  } 
  public function getName(){}

  /**
   * @param string $name
   *
   * @return $this
   */
  public function setName($name){}

  /**
   * @return int
   */
  public function getSize(){
  $filesize=0;
	if ($this->_size != 0) { 
		if ($this->_size>=1099511627776) $filesize = round($this->_size / 1024 / 1024 / 1024 / 1024, 2)." TB";
		elseif ($this->_size>=1073741824) $filesize = round($this->_size / 1024 / 1024 / 1024, 2)." GB";
		elseif ($this->_size>=1048576) $filesize = round($this->_size / 1024 / 1024, 2)." MB";
		elseif ($this->_size>=1024) $filesize = round($this->_size / 1024, 2)." KB";
		elseif ($this->_size<1024) $filesize = round($this->_size / 1024, 2)." B";
	  }
	  return $filesize;
	}
  /**
   * @param int $size
   *
   * @return $this
   */
  public function setSize($size){
	
		$this->_size=$size;

}
  /**
   * @return DateTime
   */
  public function getCreatedTime(){}

  /**
   * @param DateTime $created
   *
   * @return $this
   */
  public function setCreatedTime($created){}

  /**
   * @return DateTime
   */
  public function getModifiedTime(){}

  /**
   * @param DateTime $modified
   *
   * @return $this
   */
  public function setModifiedTime($modified){}

  /**
   * @return FolderInterface
   */
  public function getParentFolder(){}

  /**
   * @param FolderInterface $parent
   *
   * @return $this
   */
  public function setParentFolder(FolderInterface $parent){}

  /**
   * @return string
   */
  public function getPath(){}
}
