<?php namespace Simpleet\Library\Navigation;
/**
 * Navigation Class
 * 
 * * Creates a navigation list that can easily add/remove navigation nodes. It
 * also supports nested navigation lists to allow multiple level navigation.
 *
 * @author Phuah Kok Keong
 * @copyright Simpleet Sdn. Bhd 
 */


class NavigationList {
	/**
	 * @var string The CSS ID of the navigation list. 
	 */
	public $id;

	/**
	 * @var string The CSS Class name of the navigation list
	 */
	public $class;

	/**
	 * @var array Stores the navigation nodes
	 */
	public $nodes = array();

	/**
	 * Initialise the object and configuration settings
	 */
	public function __construct($options = array())
	{
	}

	public function setId( $id )
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Add a navigation node
	 *
	 * @param array  $args     List of arguments for the node:
	 *   - string   'key'       Unique key identifier for the node in a list
	 *   - string   'title':    Node Title
	 *   - string   'location': Location that the node points to
	 *   - string   'image':    Path of the image, if the node uses an image
	 *   - boolean  'active'    Marks the node as an active node or not
	 *   - boolean  'external'  Does this node point to an external resource (opens in a new window)
	 *   - string   'class'     Class of the node (e.g. node-home)
	 *   - string   'html'      If the node uses a route/view, the generated html will be stored here. HTML can be passed directly as well
	 *   - array    'children'  An array of Navigationlist object keys to be attached as children
	 *
	 * When a node is rendered, it will display in the following order:
	 *  1. html
	 *  2. image
	 *  3. anchor link
	 *
	 * So if there's no HTML generated, it will see if there's an image path, if none it will create an anchor link.
	 *
	 * Multiple Navigationlist objects can be attached as children of a node.
	 */
	public function add( $args = array() )
	{
		// Make sure a key is specified
		$key = array_get($args, 'key', '');
		if ( strlen($key) )
		{
			$this->nodes[$key] = array( 'title'    => array_get($args, 'title',    ''),
			                            'location' => array_get($args, 'location', ''),
			                            'class'    => array_get($args, 'class',    ''),
			                            'active'   => array_get($args, 'active',   false),
			                            'external' => array_get($args, 'external', false),
			                            'image'    => array_get($args, 'image',    ''),
			                            'html'     => array_get($args, 'html',     ''),
			                            'children' => array_get($args, 'children', array()),
			                            'key'      => $key
			);
		}
	}

	public function update( $args = array() )
	{
		$this->add($args);
	}

	/**
	 * Remove a navigation node
	 *
	 * @param string $key Key that identifies node to be removed
	 */
	public function remove( $key )
	{
		unset($this->nodes[$key]);
	}

	/**
	 * Attaches another Navigationlist object to specified node
	 *
	 * @param string $key Key that identifies node to attach object
	 */
	public function attach( $key,
	                        $list_obj )
	{
		$this->nodes[$key]['children'][] = $list_obj;
	}

	/**
	 * Detaches Navigationlist object from specified node
	 *
	 * @param string $key Key that identifies node to detach object
	 */
	public function detach( $key, $object )
	{
		$total = count($this->nodes[$key]['children']);
		for ( $i = 0; $i < $total; $i++ )
		{
			if ( $this->nodes[$key]['children'][$i] === $object )
			{
				unset($this->nodes[$key]['children'][$i]);
			}
		}
	}

	/**
	 * Sets a navigation node as being the current active node
	 *
	 * @param string $key Key that identifies node to set as active
	 */
	public function active( $key )
	{
		if ( isset($this->nodes[$key]) )
		{
			$this->nodes[$key]['active'] = true;
		}
	}
	/**
	 * Resets all nodes to inactive
	 *
	 */
	public function resetActive()
	{
		foreach ( $this->nodes AS $key => $node )
		{
			$this->nodes[$key]['active'] = false;
		}
	}

	/**
	 * Sets a navigation node as inactive node
	 *
	 * @param string $key Key that identifies node to set as inactive
	 */
	public function inactive( $key )
	{
		if ( isset($this->nodes[$key]) )
		{
			$this->nodes[$key]['active'] = true;
		}
	}

	/**
	 * Check if a node is active
	 *
	 * @param string $key Key that identifies node
	 */
	public function isActive( $key )
	{
		if ( isset($this->nodes[$key]) )
		{
			return $this->nodes[$key]['active'];
		}
		return false;
	}


	/**
	 * Gets the title of a node
	 *
	 * @param string $key Key that identifies node
	 */
	public function getTitle( $key )
	{
		if ( isset($this->nodes[$key]) )
		{
			return $this->nodes[$key]['title'];
		}
		else
		{
			return '';
		}
	}

	/**
	 * Gets the image of a node
	 *
	 * @param string $key Key that identifies node
	 */
	public function getImage( $key )
	{
		if ( isset($this->nodes[$key]) )
		{
			return $this->nodes[$key]['image'];
		}
		else
		{
			return '';
		}
	}

	/**
	 * Gets the html of a node
	 *
	 * @param string $key Key that identifies node
	 */
	public function getGtml( $key )
	{
		if ( isset($this->nodes[$key]) )
		{
			return $this->nodes[$key]['html'];
		}
		else
		{
			return '';
		}
	}

 	public function render( $renderCallback = null )
	{
		return call_user_func($renderCallback, $this);
	}

	public function output( $renderCallback = null )
	{
		echo $this->render($renderCallback);
	}

}