<?php
/**
 * GitSwitch.php
 * 
 * This is a script for integrating GitHub issues with PivotalTracker. It allows a panel to be created in PivotalTracker
 * that will allow issues/bugs to be imported from GitHub. Please note GitSwitch does not allow you to directly update 
 * or modify issues in GitHub from PivotalTracker. It is currently export only GitHub --> PivotalTracker. If you would
 * like to see update/modify functionality in a future release please contact me at contact@jaspervalero.com and let me know.
 * 
 * GitSwitch uses the GitHub API v2.
 * 
 * @name GitSwitch.php
 * @author Jasper Valero <contact@jaspervalero.com>
 * @copyright Creative Commons 3.0 Attribution
 * @version 1.0
 * @link http://jaspervalero.com
 */
header("Content-type: text/xml");

/**
 * @static Switches GitHub Issues JSON into formatted XML for integration with PivotalTracker.
 */
class GitSwitch 
{	
	/**
	 * Static var Boolean determines if class has been initialized.
	 */
	private static $initialized = FALSE;
	
	/**
	 * @static Checks to see if the class has been initialized, if not it initializes it.
	 */
	private static function init() 
	{
		if(self::$initialized)
			return;
		self::$initialized = TRUE;
	}	
	
	/**
	 * @static Fetches JSON data from GitHub Issues API v2 and formats it into PivotalTracker ready XML.
	 */
	public static function fetchIssues() 
	{
		/**
		 * Initializes the class.
		 */
		self::init();
		
		/***************************************************************************************
	 	* EDIT THE FOLLOWING PROPERTIES TO INTEGRATE THIS SCRIPT WITH YOUR GITHUB REPOSITORY   *
	 	***************************************************************************************/
	
		/**
		 * The following properties are mandatory and must be set accurately in order for this script to work.
		 */ 
		$username = "jaspervalero"; // Repository owner's GitHub username i.e. "jaspervalero"
		$repo = "GitSwitch"; // The name of the repository you want to export issues from i.e. "GitSwitch"
		$requester = "Jasper Valero"; // Name that will display next to "requested" in PivotalTracker stories i.e. "Jasper Valero"
		$state = "open"; // Imports either "open" (Default) or "closed" issues
		
		/**
		 * GitSwitch offers three import modes to CHOOSE from:
		 * (1) "list"   = Imports all "open" or "closed" issues
		 * (2) "label"  = Imports issues that have a certain label assigned in GitHub
		 * (3) "search" = Imports issues that contain a certain keyword
		 */
		$mode = "list"; // "list" Default
		$label = ""; // LEAVE BLANK unless mode is set to "label"
		$keyword = ""; // LEAVE BLANK unless mode is set to "search" 
	
		/***************************************************************************************
	 	* DO NOT EDIT BEYOND THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING                      *
	 	***************************************************************************************/
		
		/**
		 * Create request URL based on properties and current mode to fetch data from GitHub Issues API.
		 */
		// List Mode - Format: http://github.com/api/v2/json/issues/list/:user/:repo/open
		if($mode == "list")
		{
			$requestURL = "http://github.com/api/v2/json/issues/list/" . $username . "/" . $repo . "/" . $state;
		} // Label Mode - Format: http://github.com/api/v2/json/issues/list/:user/:repo/label/:label
		  else if($mode == "label") {
			$requestURL = "http://github.com/api/v2/json/issues/list/" . $username . "/" . $repo . "/label/" . $label;
		} // Label Mode - Format: http://github.com/api/v2/json/issues/search/:user/:repo/:state/:search_term
		  else if($mode == "search") {
			$requestURL = "http://github.com/api/v2/json/issues/search/" . $username . "/" . $repo . "/" . $state . "/" . $keyword;	
		}
		
		/**
		 * Create array of issues returned from the API query
		 */
		$issuesArray = self::query($requestURL);
		
		/**
		 * Parse JSON from array and format into PivotalTracker ready XML
		 */
		$xmlOutput = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$xmlOutput .= "<external_stories type=\"array\">\n";
		foreach($issuesArray['issues'] as &$issue) {
			$xmlOutput .= "	<external_story>\n";
			$xmlOutput .= "		<external_id>" . $issue['number'] . "</external_id>\n";
			$xmlOutput .= "		<name>BUG " . $issue['title'] . "</name>\n";
			$xmlOutput .= "		<description>" . $issue['body'] . " GitHub URL: " . $issue['html_url'] . "</description>\n";
			$xmlOutput .= "		<requested_by>" . $requester . "</requested_by>\n";
			$xmlOutput .= "		<created_at type=\"datetime\">" . $issue['created_at'] . "</created_at>\n";
			$xmlOutput .= "		<story_type>BUG</story_type>\n";
			$xmlOutput .= "		<estimate type=\"integer\">1</estimate>\n";
			$xmlOutput .= "	</external_story>\n";
		}
		$xmlOutput .= "</external_stories>";
		
		/**
		 * Output formatted XML to PivotalTracker
		 */
		echo $xmlOutput;
	}

	/**
	 * Makes requests to the GitHub Issues API
	 */
	private static function query($url)
	{
		/**
		 * Initializes the class.
		 */
		self::init();
		
		/**
		 * Catch the JSON Data
		 */
		$jsonData = file_get_contents($url);
		
		/**
		 * Create data array from JSON data
		 */
		$jsonArray = json_decode($jsonData, true);
		
		return $jsonArray;
	}
}

/**
 * Self construct the static class and fetch issues from GitHub
 */	
GitSwitch::fetchIssues();
