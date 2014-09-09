<?php 
/**
 * Navigation Class
 * 
 * * Creates a navigation list that can easily add/remove navigation nodes. It
 * also supports nested navigation lists to allow multiple level navigation.
 *
 * @author Phuah Kok Keong
 * @copyright Simpleet Sdn. Bhd 
 */

namespace Simpleet\Library\Navigation;

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
	protected $node = array();

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
	 *   - array    'children'  An array of Navigationlist objects to be attached as children
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
		if ( !empty($key) )
		{
			// Check and verify navigationlist objects
			$children = array_get($args, 'children', array());
			$total    = count($children);

			for ( $i = 0; $i < $total; $i++ )
			{
				if ( !($children[$i] instanceof Navigation) )
				{
					unset($children[$i]);
				}
			}

			$this->node[$key] = array( 'title'    => array_get($args, 'title',    ''),
			                           'location' => $location,
			                           'class'    => array_get($args, 'class',    ''),
			                           'active'   => array_get($args, 'active',   false),
			                           'external' => array_get($args, 'external', false),
			                           'image'    => array_get($args, 'image',    ''),
			                           'html'     => $html,
			                           'children' => $children,
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
		unset($this->node[$key]);
	}

	/**
	 * Attaches another Navigationlist object to specified node
	 *
	 * @param string $key Key that identifies node to attach object
	 */
	public function attach( $key,
	                        $list_obj )
	{
		$this->node[$key]['children'][] = $list_obj;
	}

	/**
	 * Detaches Navigationlist object from specified node
	 *
	 * @param string $key Key that identifies node to detach object
	 */
	public function detach( $key, $object )
	{
		$total = count($this->node[$key]['children']);
		for ( $i = 0; $i < $total; $i++ )
		{
			if ( $this->node[$key]['children'][$i] === $object )
			{
				unset($this->node[$key]['children'][$i]);
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
		if ( isset($this->node[$key]) )
		{
			$this->node[$key]['active'] = true;
		}
	}
	/**
	 * Resets all nodes to inactive
	 *
	 */
	public function resetActive()
	{
		foreach ( $this->node AS $key => $node )
		{
			$this->node[$key]['active'] = false;
		}
	}

	/**
	 * Sets a navigation node as inactive node
	 *
	 * @param string $key Key that identifies node to set as inactive
	 */
	public function inactive( $key )
	{
		if ( isset($this->node[$key]) )
		{
			$this->node[$key]['active'] = true;
		}
	}

	/**
	 * Check if a node is active
	 *
	 * @param string $key Key that identifies node
	 */
	public function isActive( $key )
	{
		if ( isset($this->node[$key]) )
		{
			return $this->node[$key]['active'];
		}
		return false;
	}


	/**
	 * Gets the title of a node
	 *
	 * @param string $key Key that identifies node
	 */
	public function get_title( $key )
	{
		if ( isset($this->node[$key]) )
		{
			return $this->node[$key]['title'];
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
	public function get_image( $key )
	{
		if ( isset($this->node[$key]) )
		{
			return $this->node[$key]['image'];
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
	public function get_html( $key )
	{
		if ( isset($this->node[$key]) )
		{
			return $this->node[$key]['html'];
		}
		else
		{
			return '';
		}
	}
}