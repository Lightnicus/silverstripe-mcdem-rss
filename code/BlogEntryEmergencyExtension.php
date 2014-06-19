<?php 

class BlogEntryEmergencyExtension extends DataExtension{
	
	static $db = array(
		'EmergencyType' => 'Text'
	);
	
	static $default_sort = 'Created DESC';
	
	function updateCMSFields(FieldList $fields) {	
		if($this->isEmergencyFeed()){
			$types = array(
				'Earthquakes' => 'Earthquakes',
				'VolcanicUnrest' => 'Volcanic unrest',
				'Landslides' => 'Landslides',
				'Tsunami' => 'Tsunami',
				'CoastalHazards' => 'Coastal hazards',
				'Floods' => 'Floods',
				'SevereWeather' => 'Severe weather',
				'InfrastructureFailure' => 'Infrastructure failure',
				'Drought' => 'Drought',
				'Biosecurity' => 'Biosecurity',
				'FoodSafety' => 'Food safety',
				'Pandemic' => 'Pandemic',
				'Wildfire' => 'Wildfire',
				'HazardousSubstanceIncidents' => 'Hazardous substance incidents',
				'Terrorism' => 'Terrorism',
				'MajorTransportAccident' => 'Major transport accident',
				'MarineOilSpill' => 'Marine oil spill',
				'RadiationIncident' => 'Radiation incident',
				'Other' => 'Other'
			);

			$fields->addFieldToTab('Root.Emergency', new DropdownField('EmergencyType', 'Emergency Type', $types, '', '', '- please select -'));
		}
	}

	/**
	* Returns an Emergency value based on the key
	*/
	function getEmergencyReal() {
		$emergency = $this->owner->EmergencyType;
		$types = array(
			'Earthquakes' => 'Earthquakes',
			'VolcanicUnrest' => 'Volcanic unrest',
			'Landslides' => 'Landslides',
			'Tsunami' => 'Tsunami',
			'CoastalHazards' => 'Coastal hazards',
			'Floods' => 'Floods',
			'SevereWeather' => 'Severe weather',
			'InfrastructureFailure' => 'Infrastructure failure',
			'Drought' => 'Drought',
			'Biosecurity' => 'Biosecurity',
			'FoodSafety' => 'Food safety',
			'Pandemic' => 'Pandemic',
			'Wildfire' => 'Wildfire',
			'HazardousSubstanceIncidents' => 'Hazardous substance incidents',
			'Terrorism' => 'Terrorism',
			'MajorTransportAccident' => 'Major transport accident',
			'MarineOilSpill' => 'Marine oil spill',
			'RadiationIncident' => 'Radiation incident',
			'Other' => 'Other'
		);
		if(array_key_exists($emergency, $types)){
			return $types[$emergency];
		} else {
			return false;
		}

		
	}

	/**
	* Returns the Content with HTML tags stripped.
	*/
	function Description(){
       	return strip_tags($this->owner->Content);
	}

	/**
	 * PubDate function takes the Created date of the DataObject and formats it appropriately for
	 * an RSS feed.
	 */
	function PubDate() {
		if($this->owner->Created) {
			return date('D, d M Y H:i:s O', strtotime($this->owner->Created));
		}
	}

	/**
	 * UpdateDate function is very similar to the PubDate function. The difference is that it uses
	 * the LastEdited date as opposed to the Created date
	 */
	function UpdateDate() {
		$edit = $this->owner->LastEdited;
		if($edit && $edit != $this->owner->Created) {
			return date('D, d M Y H:i:s O', strtotime($edit));
		}
	}

	/**
	* Deteremines whether this Blog Entry belongs to an Emergency Feed
	*/
	function isEmergencyFeed(){
		$isEmergencyFeed = false;

		$parentID = $this->owner->ParentID;

		if($parentID != 0){
			$parent = SiteTree::get()->byID($parentID);

			if($parent->EmergencyFeed){
				$isEmergencyFeed = true;
			}
		}

		return $isEmergencyFeed;
	}

	/**
	 * Generates a unique ID for the guid tag
	 */
	function UniqueID() {
		$hash = hash('sha256', $this->owner->Title . ' ' . $this->owner->Created);
		return $hash;
	}

}