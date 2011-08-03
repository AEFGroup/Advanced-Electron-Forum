<?php

/////////////////////////////////////////////////////////////////
//===============================================================
// backup_lang.php(languages/english/admin)
//===============================================================
// AEF : Advanced Electron Forum 
// Version : 1.0.9
// Inspired by Pulkit and taken over by Electron
// Extract text from admin files by oxlo (16th January 2008).
// --------------------------------------------------------------
// Started by: Electron, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelectron.com/ (Anelectron)
// --------------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// --------------------------------------------------------------
//===============================================================
// (C)AEF Group All Rights Reserved.
//===============================================================
/////////////////////////////////////////////////////////////////

$l['no_path'] = 'The folder path was not specified.';
$l['no_readable_path'] = 'The folder path you submitted is not readable.';
$l['no_compression'] = 'The compression method was not specified.';
$l['compression_invalid'] = 'The compression method you specified is invalid.';
$l['unaccessible_local_path'] = 'The local storage path you submitted is not accessible.';
$l['errors_compressing_data'] = 'There were some errors while compressing the data.';
$l['backup_ok'] = 'Successfully backed up';
$l['backup_created_ok'] = 'Backup created successfully';
$l['backup_created_ok_exp'] = 'The backup was created successfully.<br />You may now return to the <a href="'.$globals['index_url'].'act=admin">Admin Index</a> or the <a href="'.$globals['index_url'].'act=admin&adact=backup">Backup Tools</a>.<br /><br />
		
		Thankyou!';
$l['errors_writing'] = 'There were some errors while writing the file on the server.';
$l['no_tables_specified'] = 'The tables to be exported was not specified.';
$l['tables_invalid'] = 'The tables you specified are invalid.';
$l['select_structure_data'] = 'You must select either the Structure or Data or Both to export something.';
$l['no_zip'] = 'Your server does not support Zip Compression.';
$l['no_gzip'] = 'Your server does not support GZip Compression.';
$l['no_bzip'] = 'Your server does not support BZip Compression.';

//Theme Strings
$l['cp_ff_backup'] = 'Admin Center - Backup';
$l['ff_backup'] = 'File and Folder Backup';
$l['ff_backup_exp'] = 'This feature will allow you to backup the files and folder of your AEF board. You can backup a particular folder also within AEF.';
$l['backup_options'] = 'Backup options';
$l['folder_'] = 'Folder :';
$l['folder_exp'] = 'The folder you want to backup.';
$l['compression'] = 'Compression :';
$l['store_locally'] = 'Store locally :';
$l['store_locally_exp'] = 'If you want to download the archived file now please <b>do not</b> fill this text box. If you want to store the archived file locally on this server then please specify the path.';
$l['submit'] = 'Submit';
$l['cp_database_backup'] = 'Administration Center - Database Backup';
$l['database_backup'] = 'Database Backup';
$l['database_backup_exp'] = 'In this section of the board you can backup your AEF Boards database. Please take regular backups of your Database.';
$l['database_backup_options'] = 'Database Backup Options';
$l['tables'] = 'Tables :';
$l['select_tables'] = 'Select the tables you want to backup.';
$l['select_all'] = 'Select All';
$l['unselect_all'] = 'Unselect All';
$l['structure'] = 'Structure :';
$l['add_drop_table'] = 'Add <b>DROP TABLE</b>';
$l['add_if_not_exist'] = 'Add <b>IF NOT EXISTS</b>';
$l['add_autoincrement'] = 'Add <b>Auto Increment</b> values';
$l['enclose_backquotes'] = 'Enclose table and field names with <b>backquotes</b>';
$l['data'] = 'Data :';
$l['use_delayed_inserts'] = 'Use Delayed inserts';
$l['use_ignore_inserts'] = 'Use Ignore inserts';
$l['compression'] = 'Compression :';
$l['none'] = 'None';
$l['zip'] = 'Zip';
$l['tar'] = 'Tar';
$l['gzip'] = 'GZip';
$l['bzip'] = 'BZip';

?>