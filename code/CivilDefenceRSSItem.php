<?php

class CivilDefenceRSSItem extends DataObject {
	
	public static $EMERGENCY_TYPES = array(
		'Earthquakes' 					=> 'Earthquakes',
		'VolcanicUnrest' 				=> 'Volcanic unrest',
		'Landslides' 					=> 'Landslides',
		'Tsunami' 						=> 'Tsunami',
		'CoastalHazards' 				=> 'Coastal hazards',
		'Floods' 						=> 'Floods',
		'SevereWeather' 				=> 'Severe weather',
		'InfrastructureFailure' 		=> 'Infrastructure failure',
		'Drought' 						=> 'Drought',
		'Biosecurity' 					=> 'Biosecurity',
		'FoodSafety' 					=> 'Food safety',
		'Pandemic' 						=> 'Pandemic',
		'Wildfire' 						=> 'Wildfire',
		'HazardousSubstanceIncidents' 	=> 'Hazardous substance incidents',
		'Terrorism' 					=> 'Terrorism',
		'MajorTransportAccident' 		=> 'Major transport accident',
		'MarineOilSpill' 				=> 'Marine oil spill',
		'RadiationIncident' 			=> 'Radiation incident',
		'Other' 						=> 'Other'
	);
	
	
	static $db = array(
		'Title' => 'Varchar(80)',
		'Description' => 'Text',
		'Emergency' => 'Boolean',
		'EmergencyType' => 'Text'
	);
	
	static $has_one = array(
		'Page' => 'CivilDefencePage'
	);

	static $summary_fields = array(
		'Title',
		'Description',
		'Emergency'
	);

	static $default_sort = 'Created DESC';
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new TextField('Title'));
		$fields->addFieldToTab('Root.Main', new TextareaField('Description'));
		$fields->addFieldToTab('Root.Main', new CheckboxField('Emergency', 'Is this an Emergency?'));
		$fields->addFieldToTab('Root.Main', new DropdownField('EmergencyType', 'Emergency Type', self::$EMERGENCY_TYPES, '', '', '- please select -'));
		return $fields;
	}

	function getEmergencyReal() {
		if($this->Emergency) {
			$emergency = $this->EmergencyType;
			return self::$EMERGENCY_TYPES[$emergency];
		}
		return;
	}

	/**
	 * PubDate function takes the Created date of the DataObject and formats it appropriately for
	 * an RSS feed.
	 */
	function PubDate() {
		if($this->Created) {
			return date('D, d M Y H:i:s O', strtotime($this->Created));
		}
	}

	/**
	 * UpdateDate function is very similar to the PubDate function. The difference is that it uses
	 * the LastEdited date as opposed to the Created date
	 */
	function UpdateDate() {
		$edit = $this->LastEdited;
		if($edit && $edit != $this->Created) {
			return date('D, d M Y H:i:s O', strtotime($edit));
		}
	}
	
	/**
	 * A globally unique identifier, which changes when updated
	 */
	function GUID(){
		$page = $this->Page();
		if(!$page) return '';
		return $page->Link() . ' - ' . $this->ID . ' - ' . $this->PubDate();
	}
	
	function GUIDHash(){
		return md5($this->GUID);
	}
	
}