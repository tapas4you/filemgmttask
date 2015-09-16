<?php
require_once 'includes/config.php';
require_once 'classes/class.Folder.php';
require_once 'classes/class.File.php';
require_once 'classes/class.FileSystem.php';
require_once 'classes/class.HTML.php';
$oHTML=new HTML();
$oFileSystem =new FileSystem();
$oFolder =new Folder();
$oFile =new File();
if(!empty($_REQUEST['id'])){
	$id=$_REQUEST['id'];
}else{
	$id='home';
}
if(!empty($_REQUEST['page'])){
	$request_page=$_REQUEST['page'];
	$page='/'.$_REQUEST['page'];
	$folderPath=DIRECTORY.$_REQUEST['page'];
}else{
	$request_page=NULL;
	$page='/';
	$folderPath=DIRECTORY;
}
switch($id) {
	case "home":
	$filelist=$oFileSystem->getFolders(new Folder($folderPath));
    //$homeHTML=$oHTML->createHome($filelist,$page,$folderPath,$request_page);
	$fileurlpath=$_SERVER['SCRIPT_NAME'];
	$action=NULL;
	$size=NULL;
	$permission=NULL;
	$totalsize=0;
	$IMG_MIME_FOLDER = "images/mime/folder.png";
	$IMG_MIME_BINARY = "images/mime/page_white_gear.png";
	$IMG_MIME_AUDIO = "images/mime/page_white_cd.png";
	$IMG_MIME_VIDEO = "images/mime/page_white_camera.png";
	$IMG_MIME_IMAGE = "images/mime/page_white_picture.png";
	$IMG_MIME_TEXT = "images/mime/page_white_text.png";
	$IMG_MIME_UNKNOWN = "images/mime/page_white.png";
	$IMG_CHECK = "images/icons/accept.png";
	$IMG_RENAME = "images/icons/font.png";
	$IMG_GET = "images/icons/drive_go.png";
	$IMG_EDIT = "images/icons/page_edit.png";
	$IMG_DELETE = "images/icons/delete.png";
	$IMG_MOVE = "images/icons/folder_go.png";
	$IMG_CHMOD = "images/icons/lock.png";
	$IMG_ACTION = "images/icons/bullet_arrow_down.png";
	echo "<a href=\"".$fileurlpath."?id=createFolder&page=$request_page\">Create Folder</a>\n";
	echo $oHTML->title($page);
	$homeHTML ='<table width="100%" cellspacing="1" cellpadding="1" border="1"><tr bgcolor="#FFCC99" height="25" width="20"><td>File Name</td><td>Action</td><td>Size</td><td>Permission</td></tr>';
		$count=0;
		foreach($filelist as $key=>$fileinfo){
			$action=NULL;
			$size=0;
			if($fileinfo != "." && $fileinfo != ".."){
			$count++;
				if (strlen($fileinfo)>50) {
					$filename = substr($fileinfo,0,50)."...";
				}else{
					$filename = $fileinfo;
				}
				if (is_dir($folderPath.$fileinfo) && is_readable($folderPath.$fileinfo)) { 
        			$permission = substr(sprintf('%o', @fileperms($folderPath.$fileinfo)), -4);
					
					$oFile->setSize($size);
					$mimeimage="<img src=\"$IMG_MIME_FOLDER\">";
					$action = "<a href=\"".$fileurlpath."?id=rename&file=".$fileinfo."&page=$request_page\"><img src=\"$IMG_RENAME\" border=0 \"></a>\n";
					$action .="<a href=\"".$fileurlpath."?id=deleteFolder&file=".$fileinfo."&page=$request_page\"><img src=\"$IMG_DELETE\" border=0 \"></a>\n";
					$filename = "<a href=\"".$fileurlpath."?id=home&page=".$request_page.$fileinfo."/\">".$filename."</a>\n";
				} elseif (!is_dir($folderPath.$fileinfo) && is_readable($folderPath.$fileinfo)) { 
        			$permission = substr(sprintf('%o', @fileperms($folderPath.$fileinfo)), -4);
       				$size = filesize($folderPath.$fileinfo); 
					$totalsize = $totalsize + $size;
					$oFile->setSize($size);
					
					$type = mime_content_type($folderPath.$fileinfo);
					if (substr($type,0,4) == "text") $mimeimage = "<img src=\"$IMG_MIME_TEXT\">";
					elseif (substr($type,0,5) == "image") $mimeimage = "<img src=\"$IMG_MIME_IMAGE\">";
					elseif (substr($type,0,11) == "application") $mimeimage = "<img src=\"$IMG_MIME_BINARY\">";
					elseif (substr($type,0,5) == "audio") $mimeimage = "<img src=\"$IMG_MIME_AUDIO\">";
					elseif (substr($type,0,5) == "video") $mimeimage = "<img src=\"$IMG_MIME_VIDEO\">";
					elseif (substr($type,0,5) == "model") $mimeimage = "<img src=\"$IMG_MIME_IMAGE\">";
					elseif (substr($type,0,7) == "message") $mimeimage = "<img src=\"$IMG_MIME_TEXT\">";
					elseif (substr($type,0,9) == "multipart") $mimeimage = "<img src=\"$IMG_MIME_TEXT\">";
					else $mimeimage = "<img src=\"$IMG_MIME_UNKNOWN\">";
					$edit = "";
					$rename = "";
					$get = "";
					//$edit = "<a href=\"".$fileurlpath."?id=edit&file=".$fileinfo."&page=$request_page\"><img src=\"$IMG_EDIT\" border=0 \"></a>\n";
					$rename = "<a href=\"".$fileurlpath."?id=rename&file=".$fileinfo."&page=$request_page\"><img src=\"$IMG_RENAME\" border=0 \"></a>\n";
					$delete = "<a href=\"".$fileurlpath."?id=deleteFile&file=".$fileinfo."&page=$request_page\"><img src=\"$IMG_DELETE\" border=0 \"></a>\n";
					$get = "<a href=\"".$fileurlpath."?id=view&file=".$fileinfo."&page=$request_page\"><img src=\"$IMG_GET\" border=0 \"></a>\n";
					$action=$rename.$delete.$edit.$get;
				}else {
					//echo "<font class=error>Directory '$fileinfo' is unreadable.</font><br>\n";
				}
				
				$homeHTML .='<tr><td>'.$mimeimage.$filename.'</td><td>'.$action.'</td><td>'.$oFile->getSize().'</td><td>'.$permission.'</td></tr>';
			}
			
		}
		$oFile->setSize($totalsize);
		$homeHTML .='<tr><td colspan="2">Files:'.$count.'</td><td colspan="2">'.$oFile->getSize().'</td</tr></table>';

	
	
	echo $homeHTML;die;
    break;
	case "deleteFile":
	$file=$_REQUEST['file'];
	unlink($folderPath.$file);
	header("location:".$fileurlpath."?id=home&page=".$request_page);die();
	break;
	case "deleteFolder":
	$file=$_REQUEST['file'];
	$oFileSystem->deleteFolder(new Folder($folderPath.$file));
	header("location:".$fileurlpath."?id=home&page=".$request_page);die();
	break;
	case "view":
	$file=$_REQUEST['file'];
	$file = basename($folderPath.$file);
 	$len = filesize($filep);

  header("Cache-Control: no-store, no-cache, must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Content-type: application/force-download");
  header("Content-Length: $len");
  header("Content-Disposition: inline; filename=$file");
  header("Accept-Ranges: $len"); 
  readfile($filep);
	break;
	
	
case "rename":
	$file=$_REQUEST['file'];
	$fileurlpath=$_SERVER['SCRIPT_NAME'];
	echo "<form action=\"".$fileurlpath."?id=renamesave&page=$request_page\" method=\"post\">\n"
        ."Renaming '".$page.$file."'\n"
        ."<br>\n"
        ."<input type=\"hidden\" name=\"rename\" value=\"".$file."\">\n"
        ."<input class=\"text\" type=\"text\" size=\"40\" width=\"40\" name=\"nrename\" value=\"".$file."\">\n"
        ."<input type=\"Submit\" value=\"Rename\" class=\"button\">\n";
	break;
	
	
	case "renamesave":
	$fileurlpath=$_SERVER['SCRIPT_NAME'];
	$rename=$_REQUEST['rename'];
	$nrename=$_REQUEST['nrename'];
	
	rename($folderPath.$rename,$folderPath.$nrename);
	header("location:".$fileurlpath."?id=home&page=".$request_page);die();
	break;
	
	
	case "createFolder":
	//$file=$_REQUEST['file'];
	$fileurlpath=$_SERVER['SCRIPT_NAME'];
	echo "<form action=\"".$fileurlpath."?id=savefolder&page=$request_page\" method=\"post\">\n"
        ."Creating Folder at: '".$page."'\n"
        ."<br>\n"
        ."<input class=\"text\" type=\"text\" size=\"40\" width=\"40\" name=\"nrename\" value=\"\">\n"
        ."<input type=\"Submit\" value=\"Rename\" class=\"button\">\n";
	break;
	case "savefolder":
	$fileurlpath=$_SERVER['SCRIPT_NAME'];
	$nrename=$_REQUEST['nrename'];
	
	mkdir($folderPath.$nrename);
	header("location:".$fileurlpath."?id=home&page=".$request_page);die();
	break;
}




?>
