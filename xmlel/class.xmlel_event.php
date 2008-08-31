<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_event extends xmlel_base {

	/**
	 * Structure about the <event></event> node
	 */
	private $tagStruct = array(
		'event' => array(
			array('tag' => 'image'),
			array('tag' => 'artists'),
			array('tag' => 'venue'),
			'id',
			'title',
			'startDate',
			'description',
			'attendance',
			'reviews',
			'tag',
			'url',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param DOMNode $domNode Node, should be a '<event></event>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	/** 
	 * Costum template markers.
	 *
	 * @param 	object	$cObj: Content object
	 * @param	array	$conf: The event configuration
	 * @return	Marker array
	 */
	public function getTemplateMarkers($cObj, $conf) {
		$markerArray = parent::getTemplateMarkers();

		$typolink_conf['parameter'] = $this->getValue('url');
		$typolink_conf['extTarget'] = '_blank';
		$markerArray['###EVENT_LINKTITLE###'] = $cObj->typolink($this->getValue('title'), $typolink_conf);
		$markerArray['###EVENT_URLTITLE###'] = $cObj->typolink($this->getValue('title'), $typolink_conf);

		$markerArray['###EVENT_IMAGE###'] = $this->filterImage($conf);

		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_event.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_event.php']);
}

?>
