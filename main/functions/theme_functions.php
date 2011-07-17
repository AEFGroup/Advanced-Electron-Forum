<?php

//////////////////////////////////////////////////////////////
//===========================================================
// theme_functions.php(functions)
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
// (c)Electron Inc.
//===========================================================
//////////////////////////////////////////////////////////////

if(!defined('AEF')){

	die('Hacking Attempt');

}


//////////////////////////////////////
// Loads the theme's registry
// file and returns the registry array
//////////////////////////////////////

function theme_registry_fn($theme_id, $uservar = false){

global $conn, $dbtables, $globals, $user, $logged_in;

	///////////////////////////
	//Get the installed Themes
	///////////////////////////
	
	$qresult = makequery("SELECT * FROM ".$dbtables['themes']." t
						LEFT JOIN ".$dbtables['theme_registry']." tr ON (tr.thid = '$theme_id'
																AND tr.uid = 0)
						WHERE t.thid = '$theme_id'");
	
	if(mysql_num_rows($qresult) < 1){
	
		return false;
		
	}
	
	$skin = mysql_fetch_assoc($qresult);
	
	//Free the resources
	@mysql_free_result($qresult);
	
	$registry = aefunserialize($skin['theme_registry']);
	
	//r_print($registry);
	
	/*if(empty($registry)){

		return false;
	
	}*/
	
	
	if(!@include_once($registry['path'].'/theme_registry.php')){
		
		//Try to load directly
		@include_once($globals['themesdir'].'/'.$skin['th_folder'].'/theme_registry.php');
		
	}
	
	if(empty($theme)){
	
		return false;
	
	}
	
	//Change all the values to the current one
	foreach($theme['registry'] as $rk => $rv){
	
		foreach($theme['registry'][$rk] as $k => $v){
		
			if(isset($registry[$k])){
			
				$theme['registry'][$rk][$k]['value'] = $registry[$k];
			
			}
		
		}
	
	}
	
	//Should we pass the users Vars
	if($uservar){
	
		$qresult = makequery("SELECT * FROM ".$dbtables['themes']." t
						LEFT JOIN ".$dbtables['theme_registry']." tr ON (tr.thid = '$theme_id'
																AND tr.uid = ".($logged_in ? $user['id'] : -1).")
						WHERE t.thid = '$theme_id'");
	
		if(mysql_num_rows($qresult) > 0){
		
			$userset = mysql_fetch_assoc($qresult);
		
			//Free the resources
			@mysql_free_result($qresult);
			
			$userregistry = aefunserialize($userset['theme_registry']);
			
			if(!empty($userregistry)){

				//Change all the values to the current one
				foreach($theme['registry'] as $rk => $rv){
				
					foreach($theme['registry'][$rk] as $k => $v){
					
						if(isset($userregistry[$k])){
						
							$theme['registry'][$rk][$k]['value'] = $userregistry[$k];
						
						}					
					
					}
					
				}//End of loop
			
			}
			
		}
		
		//Change all the values to the current one
		foreach($theme['registry'] as $rk => $rv){
		
			foreach($theme['registry'][$rk] as $k => $v){
			
				//Remove the ones that are not user options
				if(empty($theme['registry'][$rk][$k]['user'])){
				
					unset($theme['registry'][$rk][$k]);
				
				}
			
			}
			
			if(empty($theme['registry'][$rk])){
					
				unset($theme['registry'][$rk]);
			
			}				
		
		}			
	
	}//User Vars
	
	return $theme['registry'];

}

?>