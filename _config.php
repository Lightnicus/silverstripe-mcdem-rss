<?php 

if(class_exists('BlogHolder')){
	DataObject::add_extension('BlogHolder', 'BlogHolderEmergencyExtension');
}
if(class_exists('BlogHolder_Controller')){
	Object::add_extension('BlogHolder_Controller', 'BlogHolderControllerEmergencyExtenction');
}
if(class_exists('BlogEntry')){
	DataObject::add_extension('BlogEntry', 'BlogEntryEmergencyExtension');
}
