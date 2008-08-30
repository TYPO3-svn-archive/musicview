<?php

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_base.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
class xmlel_user extends xmlel_base {

	/**
	 * Structure about the <user></user> node
	 */
	private $tagStruct = array(
		'user' => array(
			array('tag' => 'image'),
			array('tag' => 'recenttrack'),
			'name',
			'url',
			'match',
		),
	);

	/**
	 * Constructor.
	 *
	 * @param 	DOMNode 	$domNode: Node, should be a '<user></user>' node
	 */
	public function __construct($domNode) {
		parent::__construct($this->tagStruct, $domNode);
	}

	 /** 
	 * Costum template markers.
	 *
	 * @param       object  $cObj: Content object
	 * @param       array   $conf: The event configuration
	 * @return      Marker array
	 */
	public function getTemplateMarkers($cObj, $conf) {
		$markerArray = parent::getTemplateMarkers($cObj, $conf);
 
		$typolink_conf['parameter'] = $this->getValue('url');
		$typolink_conf['extTarget'] = '_blank';
		$markerArray['###USER_URLNAME###'] = $cObj->typolink($this->getValue('name'), $typolink_conf);

		$markerArray['###USER_IMAGE###'] = $this->filterImage($conf);
		
		return $markerArray;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_user.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/xmlel/class.xmlel_user.php']);
}
?>
