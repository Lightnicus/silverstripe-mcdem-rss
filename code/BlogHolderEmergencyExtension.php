<?php

class BlogHolderEmergencyExtension extends DataExtension{
	
	static $db = array(
		'RSSTitle' => 'Varchar(60)',
		'RSSDescription' => 'Text',
		'EmergencyFeed' => 'Boolean'
		);

	function updateCMSFields(FieldList $fields){
		$fields->addFieldToTab('Root.RSS', new CheckboxField('EmergencyFeed', 'Is this Blog Holder an MCD Emergency Feed'));
		$fields->addFieldToTab('Root.RSS', new TextField('RSSTitle', 'RSS Title'));
		$fields->addFieldToTab('Root.RSS', new TextField('RSSDescription', 'RSS Description'));
		$fields->addFieldToTab('Root.RSS', new ReadonlyField('RSSURL', 'MCDEM RSS Address', $this->EmergencyFeedLink()));
	}

	/**
	* Returns an address to the RSS feed
	*/
	function EmergencyFeedLink(){
		return $this->owner->Link('emergencyrss');
	}

	
}

class BlogHolderControllerEmergencyExtenction extends Extension{

	static $allowed_actions = array(
		'emergencyrss'
		);


	/**
	* Get the rss feed for this blog holder's entries
	*/
	function emergencyrss() {
		$params = $this->owner->getURLParams();
		
		if($params['Action'] == 'emergencyrss') {

			return $this->owner->customise(array(
				'Page' => $this->owner,
				'Date' => date('D, d M Y H:i:s O', strtotime($this->owner->LastEdited)),
				'RSSItems' => $this->owner->Entries()
			))->renderWith('CivilDefenceFeed');
		}
	}
}