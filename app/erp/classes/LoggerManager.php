<?php
/**
 * Program name		  : LogManager.php
  * Description		  : Class for application event logging
 *
 *					          add()				       - Request to add the supplied error to the log file.
 *					          write()			       - Write the error message to the log file.
 *					          checkLogFile()	   - Check the log file is writable and not full.
 *					          getTodaysLogFile() - Get the filename of todays log file.
 *
 * Creation date	  : 21 July 2004
 * Author			      : Richard Brierton
 * Source from		  : http://www.allhype.co.uk
 * Amendment history: 
 * Date       By            Description
 * ---------  ------------- ------------------------------------------------
 *
 */

class LoggerManager{

	private $sLoggerFileName;
	private $iLoggerUserID;


  //--------------------------------------------------------
	// The constructors simply gives an initial value to all private vars
  //--------------------------------------------------------
	function LoggerManager( $sLoggerFileName = "", $iLoggerUserID = "" ){

		$this->log_file	= date( "Ym_" ) . $sLoggerFileName . ".log";
		$this->user_id	= $iLoggerUserID;
	}


  //--------------------------------------------------------
	// Request to add the supplied error to the log file
  //--------------------------------------------------------
	function add( $error = "", $this_level = "" ) {

		$this->write( $error, $this_level );
	}


	function write( $error, $this_level ){

		$this->log_file = $this->getTodaysLogFile();
		$nextline = $this->user_id."|".$_SERVER["REMOTE_ADDR"]."|".date( "Y-m-d H:i:s" )."|".$this_level."|".$error."\n";
		$checkLogFile = $this->checkLogFile();

	
		if( $checkLogFile == "valid" ){
			$file = fopen( DIR_FS_STORE_LOG_USER . $this->log_file, "a" );
			fwrite( $file, $nextline, strlen($nextline) );
			fclose( $file );
		}
		elseif( $checkLogFile == "unwritable" ){
			print "<p><strong>Logging Disabled. Log file (" . DIR_FS_STORE_LOG_USER . $this->log_file . ") unwritable.</strong></p>";
		}
	}


  //--------------------------------------------------------
	// Check the log file is writable and not full
  //--------------------------------------------------------
	function checkLogFile(){

		$this->log_file = $this->getTodaysLogFile();

		if( file_exists(DIR_FS_STORE_LOG_USER . $this->log_file) && is_writable(DIR_FS_STORE_LOG_USER . $this->log_file) ){
			$return = "valid"; 
		}
		elseif( !file_exists(DIR_FS_STORE_LOG_USER.$this->log_file) && is_writable(DIR_FS_STORE_LOG_USER) ){
			touch( DIR_FS_STORE_LOG_USER . $this->log_file );
			chmod( DIR_FS_STORE_LOG_USER . $this->log_file, 0755 );
			$return = "valid";
		}
		elseif( !file_exists(DIR_FS_STORE_LOG_USER . $this->log_file) && !is_writable(DIR_FS_STORE_LOG_USER) ){
			// @returns unwritable The file or directory cannot be written to
			$return = "unwritable";
		}
		elseif( file_exists(DIR_FS_STORE_LOG_USER . $this->log_file) && !is_writable(DIR_FS_STORE_LOG_USER . $this->log_file) ){
			// @returns unwritable The file or directory cannot be written to
			$return = "unwritable"; 
		}
		// @returns valid The file is OK
		return $return;
	}


  //--------------------------------------------------------
	// Get the filename of todays log file
  //--------------------------------------------------------
	function getTodaysLogFile(){

		$this->log_file = sprintf( $this->log_file, date("Y-m-d") );

		//@returns log_file Todays log file. Requires getRelativePath()
		return $this->log_file; 
	}
}

?>