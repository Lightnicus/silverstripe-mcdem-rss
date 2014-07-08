<?php 

class BlogEntryEmergencyExtension extends DataExtension{
	
	const RSS_DATE_FORMAT = 'D, d M Y H:i:s O';
	
	public static $EMERGENCY_TYPES = array(
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
	
	static $db = array(
		'EmergencyType' => 'Text',
		'OtherEmergencyType' => 'Text',
		'EmergencyLink' => 'Text',
		'RSSContentLastUpdatedText' => 'Text', // SS_DateTime not working
	);
	
	static $default_sort = 'Created DESC';
	
	
	function updateCMSFields(FieldList $fields) {	
		if($this->isEmergencyFeed()){
			$fields->addFieldToTab('Root.Emergency', new DropdownField('EmergencyType', 'Emergency Type', self::$EMERGENCY_TYPES, '', '', '- please select -'));
			$fields->addFieldToTab('Root.Emergency', new TextField('OtherEmergencyType', 'Emergency Type (If Other)'));
			$fields->addFieldToTab('Root.Emergency', new TextField('EmergencyLink', 'Link (Optional)'));
		}
	}

	/**
	* Returns an Emergency value based on the key
	*/
	function EmergencyTypeText(){
		if($this->owner->EmergencyType == self::$EMERGENCY_TYPES['Other']){
			return 'Other:' . $this->owner->OtherEmergencyType;
		}else{
			return self::$EMERGENCY_TYPES[$this->owner->EmergencyType];
		}
	}

	/**
	 * PubDate function takes the Created date of the DataObject and formats it appropriately for
	 * an RSS feed.
	 */
	function PubDate() {
		if($this->owner->Created) {
			return date(self::RSS_DATE_FORMAT, strtotime($this->owner->Created));
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
	 * A globally unique identifier, which changes when updated
	 */
	function GUID(){
		return $this->owner->Link() . ' - ' . $this->owner->ID . ' - ' . $this->owner->PubDate();
	}
	
	function GUIDHash(){
		return md5($this->GUID());
	}
	
	function onBeforeWrite(){
		if($this->owner->isChanged('Content', 2) || $this->owner->isChanged('Title', 2)){ 
			// isChanged() has to be level 2, as default returns true every time for some reason
			$this->owner->RSSContentLastUpdatedText = date(self::RSS_DATE_FORMAT);
		}
	}

}