<?php

//////////////////////////////////////////////////////////////
//===========================================================
// zip.php(classes)
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


class zip{

	var $datasec = array();//compressed data files and directory
	
	var $ctrl_dir = array();//central index information
	
	var $old_offset = 0;//Last offset position
	
	var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";//the end of the central index
	
	//Converts an Unix timestamp to a four byte DOS date and time format
	function unix2dostime($unixtime = 0){
	
		$timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);
		
		if($timearray['year'] < 1980){
		
			$timearray['year']    = 1980;
			$timearray['mon']     = 1;
			$timearray['mday']    = 1;
			$timearray['hours']   = 0;
			$timearray['minutes'] = 0;
			$timearray['seconds'] = 0;
			
		}
		
		return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) | ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
				
	}
	
	//Adds a directory header
	function add_dir($name, $time = 0){
	
		$name = str_replace("\\", "/", $name);
		
		$hexdtime = pack('V', $this->unix2dostime($time));
		
		$fr = "\x50\x4b\x03\x04";
		$fr .= "\x0a\x00";
		$fr .= "\x00\x00";
		$fr .= "\x00\x00";
		$fr .= $hexdtime;
		
		$fr .= pack('V',0);
		$fr .= pack('V',0);
		$fr .= pack('V',0);
		$fr .= pack('v', strlen($name) );
		$fr .= pack('v', 0 );
		$fr .= $name;
		$fr .= pack('V', 0);
		$fr .= pack('V', 0);
		$fr .= pack('V', 0);
		
		$this -> datasec[] = $fr;
		
		$new_offset = strlen(implode("", $this->datasec));
		
		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x0a\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= $hexdtime;
		$cdrec .= pack('V',0);
		$cdrec .= pack('V',0);
		$cdrec .= pack('V',0);
		$cdrec .= pack('v', strlen($name));
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('v', 0 );
		$cdrec .= pack('v', 0 );
		$ext = "\x00\x00\x10\x00";
		$ext = "\xff\xff\xff\xff";
		$cdrec .= pack('V', 16 );
		$cdrec .= pack('V', $this -> old_offset);
		$cdrec .= $name;
		
		$this -> ctrl_dir[] = $cdrec;
		
		$this -> old_offset = $new_offset;
		
		return;
		
	}
	
	//Adds a file header and compressed file
	function add_file($data, $name, $time = 0){
	
		$name = str_replace("\\", "/", $name);
		
		$hexdtime = pack('V', $this->unix2dostime($time));
		
		$unc_len = strlen($data);
		$crc = crc32($data);
		$zdata = gzcompress($data);
		$zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2);//fix crc bug
		$c_len = strlen($zdata);
		
		$fr = "\x50\x4b\x03\x04";
		$fr .= "\x14\x00";
		$fr .= "\x00\x00";
		$fr .= "\x08\x00";
		$fr .= $hexdtime;
		
		$fr .= pack('V', $crc);
		$fr .= pack('V', $c_len);
		$fr .= pack('V', $unc_len);
		$fr .= pack('v', strlen($name));
		$fr .= pack('v', 0);
		$fr .= $name;
		$fr .= $zdata;
		
		$this -> datasec[] = $fr;
		
		$new_offset = strlen(implode("", $this->datasec));
		
		$cdrec = "\x50\x4b\x01\x02";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x14\x00";
		$cdrec .= "\x00\x00";
		$cdrec .= "\x08\x00";
		$cdrec .= $hexdtime;
		$cdrec .= pack('V', $crc);
		$cdrec .= pack('V', $c_len);
		$cdrec .= pack('V', $unc_len);
		$cdrec .= pack('v', strlen($name));
		$cdrec .= pack('v', 0);
		$cdrec .= pack('v', 0);
		$cdrec .= pack('v', 0);
		$cdrec .= pack('v', 0);
		$cdrec .= pack('V', 32);
		$cdrec .= pack('V', $this -> old_offset );
		
		$this -> old_offset = $new_offset;
		
		$cdrec .= $name;
		
		$this -> ctrl_dir[] = $cdrec;
	
	}
	
	//Returns the Zip File
	function file(){
	
		$data = implode("", $this -> datasec);
		
		$ctrldir = implode("", $this -> ctrl_dir);
		
		return $data.
		$ctrldir.
		$this -> eof_ctrl_dir.
		pack("v", sizeof($this -> ctrl_dir)).
		pack("v", sizeof($this -> ctrl_dir)).
		pack("V", strlen($ctrldir)).
		pack("V", strlen($data)).
		"\x00\x00";
		
	}
	
	
}


?>
