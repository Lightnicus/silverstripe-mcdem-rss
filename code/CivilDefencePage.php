<?php 

class CivilDefencePage extends Page {
	
	static $db = array(
		'RSSTitle' => 'Text',
		'RSSDescription' => 'Text',
	);
	
	static $has_one = array();
	
	static $has_many = array(
		'RSSItems' => 'CivilDefenceRSSItem'
	);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$status = array(
			'1' => 'No current emergency',
			'2' => 'Alert',
			'3' => 'Activated',
			'4' => 'Declared Emergency',
			'5' => 'Weather warning'
		);
	
		$fields->addFieldToTab('Root.Content.RSS', new TextField('RSSTitle', 'Civil Defence RSS Feed Title'));
		$fields->addFieldToTab('Root.Content.RSS', new TextField('RSSDescription', 'Civil Defence RSS Feed Description'));
		$rssTable = new ComplexTableField(
			$this,
			'RSSItems',
			'CivilDefenceRSSItem',
			'',
			'getCMSFields'
		);
		$fields->addFieldToTab('Root.Content.RSS', $rssTable);
		
		return $fields;
	}
	
}


class CivilDefencePage_Controller extends Page_Controller {
	
	static $allowed_actions = array(
		'RSS'
	);
	
	function RSS() {
		$params = $this->getURLParams();
		if(isset($params['Action']) && strtoupper($params['Action']) == 'RSS') {
			return $this->customise(array(
				'Page' => $this,
				'Date' => date('D, d M Y H:i:s O', strtotime($this->LastEdited)),
				'RSSItems' => $this->RSSItems()
			))->renderWith('CivilDefenceFeed');
		}
	}
	
}


