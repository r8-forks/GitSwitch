<?php
/**
 * GitSwitch.php
 * 
 * This is a script for integrating GitHub issues with PivotalTracker. It allows a panel to be created in PivotalTracker
 * that will allow issues/bugs to be imported from GitHub.
 * Uses the GitHub API v2.
 * 
 * @name GitSwitch.php
 * @author Jasper Valero <contact@jaspervalero.com>
 * @copyright Creative Commons 3.0 Attribution
 * @version 1.0
 * @link http://jaspervalero.com
 */
header("Content-type: text/xml");

/**
 * @static Switches GitHub Issues JSON into XML for integration with PivotalTracker.
 */
class GitSwitch 
{
	/**
	 * Static var Boolean shows is class has been initialized.
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
		
		/**
		 * Sets the request URL which returns JSON.
		 * Format: http://github.com/api/v2/json/issues/list/:user/:repo/open
		 * Change to your own username and repo.
		 */
		$request = "http://github.com/api/v2/json/issues/list/jaspervalero/OpenDonut/open";
		
		/**
		 * Sets the name to show as the requester in PivotalTracker.
		 */
		$requester = "Jasper Valero";
		
		/**
		 * Catch the JSON Data
		 */
		$jsonData = file_get_contents($request);
		
		/**
		 * Create semantic variable name
		 */
		$issuesData = $jsonData;
		
		/**
		 * Create data array from JSON data
		 */
		$json_a = json_decode ($issuesData, true);
		
		/**
		 * Parse JSON from array and format into PivotalTracker ready XML
		 */
		$xmlOutput = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$xmlOutput .= "<external_stories type=\"array\">\n";
		foreach($json_a['issues'] as &$issue) {
			$xmlOutput .= "	<external_story>\n";
			$xmlOutput .= "		<external_id>" . $issue['number'] . "</external_id>\n";
			$xmlOutput .= "		<name>" . $issue['title'] . "</name>\n";
			$xmlOutput .= "		<description>" . $issue['body'] . $issue['html_url'] . "</description>\n";
			$xmlOutput .= "		<requested_by>" . $requester . "</requested_by>\n";
			$xmlOutput .= "		<created_at type=\"datetime\">" . $issue['created_at'] . "</created_at>\n";
			$xmlOutput .= "		<story_type>BUG</story_type>\n";
			$xmlOutput .= "		<estimate type=\"integer\">1</estimate>\n";
			$xmlOutput .= "	</external_story>\n";
		}
		$xmlOutput .= "</external_stories>";
		
		/**
		 * Output formatted XML
		 */
		echo $xmlOutput;
	}
}

/**
 * Self construct the static class and fetch issues from GitHub
 */	
GitSwitch::fetchIssues();
