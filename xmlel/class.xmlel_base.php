<?php

require_once(PATH_tslib.'class.tslib_pibase.php');

require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_error.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_artist.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_artists.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_event.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_events.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_friends.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_geopoint.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_recenttrack.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_user.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_location.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_venue.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_lfm.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_image.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_albums.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_album.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_track.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_tag.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_toptags.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_chart.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_weeklychartlist.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_playlist.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_lovedtracks.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_topalbums.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_topartists.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_toptracks.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_tracks.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_recenttracks.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_weeklyalbumchart.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_weeklyartistchart.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_neighbours.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_weeklytrackchart.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_playlists.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_similartags.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_similartracks.php');
require_once (t3lib_extMgm::extPath('musicview').'xmlel/class.xmlel_topfans.php');

/**
 * Plugin 'musicview' for the 'musicview' extension.
 *
 * @author      Christoph Gostner <christoph.gostner@gmail.com>
 * @package     TYPO3
 * @subpackage  tx_musicview
 */
abstract class xmlel_base {

	/**
	 * Children array
	 */
	public $children;
	/**
	 * Value array
	 */
	protected $values;
	/**
	 * Attribute arrays
	 */
	protected $attributes;
	/**
	 * Content
	 */
	protected $content;

	/**
	 * The constructor to parse the complete xml structure with the
	 * given tags. 
	 *
	 * @param array $tagStruct The structure with known keys
	 * @param DOMNode $domNode The node to parse
	 */
	protected function __construct($tagStruct, $domNode) {
		$this->children = array();
		$this->values = array();
		$this->attributes = array();

		$key = $this->getStructKey($tagStruct);
		if ($key && $domNode->nodeName == $key) {
			$this->addAttributes($domNode);
			$this->addChildren($tagStruct[$key], $domNode->childNodes);

			$this->content = $domNode->nodeValue;
		}
	}

	/**
	 * Get the markers for the template.
	 *
	 * @param 	object 	$cObj: Content object
	 * @param	array 	$conf: The configuration
	 * @return      The marker array
	 */
	public function getTemplateMarkers($cObj = null, $conf = array()) {
		$baseName = strtoupper($this->getName());

		$vMarkers = $this->getValueMarkers($baseName);
		$aMarkers = $this->getAttrMarkers($baseName);
		$cMarker = $this->getContentMarker();

		return array_merge($vMarkers, $aMarkers, $cMarker);
	}

	/**
	 * Get the markers for the values of the xml structure.
	 * 
	 * @param 	string	$name: The name of the tag upper case
	 * @return	The marker array for all values
	 */
	protected function getValueMarkers($name) {
		$markerArray = array();
		$tagArr = $this->getValueKeys();

		foreach ($tagArr as $tag) {
			$usedTag = strtoupper($tag);

			$marker = '###' . $name . '_' . $usedTag . '###';
			$markerArray[$marker] = $this->getValue($tag);
		}
		return $markerArray;
	}

	/**
	 * Get the markers for the attributes of the xml structure.
	 *
	 * @param	string 	$name: The name of the tag upper case
	 * @return	The marker array of the attributes
	 */
	protected function getAttrMarkers($name) {
		$markerArray = array();
		$tagArr = $this->getAttributeKeys();

		foreach ($tagArr as $tag) {
			$usedTag = strtoupper($tag);
			$marker = '###' . $name . '_ATTR_' . $usedTag . '###';
			$markerArray[$marker] = $this->getAttribute($tag);
		}
		return $markerArray;
	}

	/**
	 * Get the content marker.
	 *
	 * @return 	The content marker
	 */
	public function getContentMarker() {
		$name = strtoupper($this->getName());
		$name = '###'.$name.'_CONTENT###';

		$markerArray = array();
		$markerArray[$name] = $this->getContent();

		return $markerArray;
	}

	/**
	 * If the current object has a child identified by 'image' and the configuration
	 * has set the image.size (small|medium|large) filter the image link and return
	 * the image tag.
	 * 
	 * @param	array	$conf: The configuration (typoscript)
	 @ return	The image tag or NULL if not set|found
	 */
	protected function filterImage($conf) {
		static $width = array(
			'small' => 50,
			'medium' => 130,
			'large' => 300,
		);
	
		if ($this->cKeyExists('image') && isset($conf['image.'])) {
			$size = $conf['image.']['size'];
			$imageArr = $this->getChild('image');

			foreach ($imageArr as $image) {
				$s = $image->getAttribute('size');
				if ($size == $s && strlen($image->getContent()) > 0) {
					return '<img width="' . $width[$s] . '" src="' . $image->getContent() . '" />';
				}
			}
		}
		return '&nbsp;';
	}
	
	/**
	 * Get the url with the name of the artist.
	 *
	 * @param	object	$cObj: Content object
	 * @param	array 	$conf: The configuration
	 * @return 	The url
	 */ 
	public function getUrlName($cObj, $conf) {
		$typolink_conf['parameter'] = $this->getValue('url');
		$typolink_conf['extTarget'] = '_blank';
		return $cObj->typolink($this->getValue('name'), $typolink_conf);
	}

	/** 
	 * Get the array keys of the object's children.
	 *
	 * @return The array's keys of the object's children.
	 */
	public function getChildKeys() {
		return array_keys($this->children);
	}

	/**
	 * Get a children object.
	 *
	 * @param string $key The object's key
	 * @return The object referenced by the key
	 */
	public function getChild($key) {
		return $this->children[$key];
	}

	/**
	 * Count how many objects are referenced by the key
	 *
	 * @param string $key The object's key
	 * @return The number of objects referenced by the key
	 */
	public function countChilds($key) {
		return count($this->children[$key]);
	}

	/**
	 * Return true if the object contains elements that are referenced
	 * by $key.
	 *
	 * @param	string	$key: The key to check
	 * @return	If the object contains children referneces by the key
	 */
	public function cKeyExists($key) {
		return array_key_exists($key, $this->children);
	}

	/**
	 * Get the array keys of the values.
	 *
	 * @return The keys of the values
	 */
	public function getValueKeys() {
		return array_keys($this->values);
	}

	/**
	 * Get the value behind the key.
	 *
	 * @param string $key The key to reference the value
	 * @return The object referenced by the key
	 */
	public function getValue($key) {
		return $this->values[$key];
	}

	/**
	 * Get the keys of the attributes.
	 *
	 * @return The attribute's keys
	 */
	public function getAttributeKeys() {
		return array_keys($this->attributes);
	}

	/**
	 * Get the value of an abbributte referenced by the key.
	 *
	 * @param string $key The key to reference the value
	 * @return The value reference by the key
	 */
	public function getAttribute($key) {
		return $this->attributes[$key];
	}

	/**
	 * Get the content of the object.
	 *
	 * @return The content of the object
	 */
	public function getContent() {
		return $this->content;
	}

	public function getClassName() {
		return get_class($this);
	}

	public function getName() {
		$className = $this->getClassName();

		return substr($className, 6);
	}

	/**
	 * Get the primary tag name or false, if the structure isn't valid.
	 *
	 * @param array $tagStruct The structure to search for the name
	 * @return The key name or false if the array isn't valid
	 */
	protected function getStructKey($tagStruct) {
		$keys = array_keys($tagStruct);
		if (count($keys) == 1) {
			return $keys[0];
		}
		return false;
	}

	/**
	 * Add the attributes stored in the node element.
	 *
	 * @param DOMNode $domNode The node that contains the attributes
	 */
	protected function addAttributes($domNode) {
		if ($domNode->hasAttributes()) {
			/*DOMNamedNodeMap*/$attributes = $domNode->attributes;
			foreach ($attributes as $attr) {
				$n = $attr->name;
				$v = $attr->value;
				$this->attributes[$n] = $v;
			}
		}
	}

	/**
	 * Add the children that the element contains and which are referenced by the keys of
	 * the array structure.
	 *
	 * @param array $tagStruct The structure that contains the key names
	 * @param DOMNodeList $domNodeList The list that contains the nodes
	 */
	protected function addChildren($tagStruct, $domNodeList) {
		foreach ($tagStruct as $tag) {
			if (is_array($tag)) { // children
				$className = xmlel_base::buildXmlelClassName($tag['tag']);
				if (class_exists($className)) {
					$valArr = $this->getNodeByName($tag['tag'], $domNodeList);
					$objects = array();
					foreach ($valArr as $node) {
						$obj = new $className($node);
						array_push($objects, $obj);
					}
					$this->addChild($tag['tag'], $objects);
				}
			} else { // values
				$valArr = $this->getNodeByName($tag, $domNodeList);
				if (count($valArr) == 1) {
					$this->addValue($tag, $valArr[0]->nodeValue);
				}
			}
		}
	}

	/**
	 * Get the nodes that are identified by a name. If the node's arn't found an
	 * empty array will be returned. 
	 *
	 * @param string $name The name to compare the node's name
	 * @param DOMNodeList $nodeList The list of names to check for valid nodes
	 * @return An array with the named nodes
	 */
	protected function getNodeByName($name, $nodeList) {
		$arr = array();
		for ($i = 0; $i < $nodeList->length; $i++) {
			$n = $nodeList->item($i);
 
			if ($n->nodeName == $name) {
				array_push($arr, $n);
			}
		}
		return $arr;
	}

	/**
	 * Add a value to the object
	 *
	 * @param string $key The key to use
	 * @param string $value The value to set
	 */
	protected function addValue($key, $value) {
		$this->values[$key] = $value;
	}
 
 	/**
	 * Add a child to the object
	 *
	 * @param string $key The key to set the array
	 * @param array $arr An array with different objects (extend xmlel_base)
	 */
	protected function addChild($key, $arr) {
		$this->children[$key] = $arr;
	}

	/*
	 * Static functions to create class names for the xmlel classes.
	 * If the class doesn't exists the function returns false.
	 *
	 * @param string $name A part of the class name.
	 * @return The class name or false if the class doesn't exist.
	 */
	public static function buildXmlelClassName($name) {
		$n = 'xmlel_' . str_replace(':', '', $name);
		if (class_exists($n)) {
			return $n;
		}
		return false;
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi1/xmlel/class.xmlel_base.php'])    {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/musicview/pi1/xmlel/class.xmlel_base.php']);
}
?>
