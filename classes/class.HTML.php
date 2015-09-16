<?php

class HTML {
	private $_html=NULL;
	public function __construct() {
		
	} 
	public function  title($title) {
	   	$titlehtml="<table cellpadding=1 cellspacing=0 height=20 bgcolor=#CCCCFF width=100% class=titlebar2 height=20>\n"
		  ."<tr><td width=20><img src=images/pixel.gif width=20 height=1> <td width=100%>\n"
		  ."<font>Browsing:$title</font>\n"
		  ."</table>\n";  
		 return $titlehtml; 
	}
	
	

	
}