<?php

//////////////////////////////////////////////////////////////
//===========================================================
// attachments.php
//===========================================================
// AEF : Advanced Electron Forum 
// Version : 1.0.9
// Inspired by Pulkit and taken over by Electron
// ----------------------------------------------------------
// Started by: Electron, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelectron.com/ (Anelectron)
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// ----------------------------------------------------------
//===========================================================
// (C)AEF Group All Rights Reserved.
//===========================================================
//////////////////////////////////////////////////////////////

if(!defined('AEF')){

	die('Hacking Attempt');

}


////////////////////////////////////
// Outputs a attachment if viewable
////////////////////////////////////

function download(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	//Load the Language File
	if(!load_lang('attachments')){
	
		return false;
		
	}
	
	//Which atachment do you want ?
	if(isset($_GET['atid']) && trim($_GET['atid'])!==""){
	
		$atid = (int) inputsec(htmlizer(trim($_GET['atid'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_attachment_specified_title'], $l['no_attachment_specified']);
			
		return false;
	
	}
	
	
	//Select the attachment id
	$qresult = makequery("SELECT at.*, mt.atmt_mimetype, fp.can_view_attach
				FROM ".$dbtables['attachments']." at
				LEFT JOIN ".$dbtables['attachment_mimetypes']." mt ON (at.at_mimetype_id = mt.atmtid)
				LEFT JOIN ".$dbtables['forumpermissions']." fp ON (fp.fpfid = at.at_fid 
													AND fp.fpugid = ".$user['member_group'].")
				WHERE atid = '$atid'
				LIMIT 0,1");
				
	//Are there any attachments
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_attachment_found_title'], $l['no_attachment_found']);
			
		return false;
	
	}
	
	$attachment = mysql_fetch_assoc($qresult);
	
	//Check the attachments are allowed and the user can view
	if(!($globals['attachmentmode'] && ($user['can_view_attach'] || $attachment['can_view_attach']))){
	
		//Show a major error and return
		reporterror($l['no_download_permission_title'], $l['no_download_permission']);
		
		return false;
	
	}
	
	
	$file = $globals['attachmentdir'].'/'.$attachment['at_file'];
		
	//Check the file exists.
	if( !(file_exists($file) 
		&& is_file($file) 
		&& @filetype($file) == "file")
	 ){
		
		//Show a major error and return
		reporterror($l['file_not_exists_title'], $l['file_not_exists']);
			
		return false;
		
	 }
	 
	/////////////////////////////
	// UPDATE the download count
	/////////////////////////////
	 		
	$qresult = makequery("UPDATE ".$dbtables['attachments']."
				SET at_downloads = at_downloads + 1
				WHERE atid = '$atid'", false);

	
	//Do we know the mimetype
	if($attachment['atmt_mimetype']){
	
		header('Content-type: '.$attachment['atmt_mimetype']);
	
	}
	
	//It will be called by the original filename
	header('Content-Disposition: attachment; filename="'.$attachment['at_original_file'].'"');
	
	//The source is in the encrypted file
	if(!@readfile($file)){
	
		//Show a major error and return
		reporterror($l['output_error_title'], $l['output_error']);
			
		return false;
	
	}
	
	//Stop the output buffer
	$globals['stop_buffer_process'] = true;
	
	return true;

}

?>
