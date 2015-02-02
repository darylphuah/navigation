<?php namespace Simpleet\Library\Navigation;

/**
 * Navigation Store class
 *
 * The purpose of this class is to create an object that will be used to store
 * all the navigation list objects for easy retrieval and manipulation.
 *
 * @author     Phuah Kok Keong
 * @copyright  Copyright © 2014, Simpleet Sdn Bhd
 */

class NavigationStore
{
	protected $_store = array();

	public function __construct( $options = array() ) 
	{

	}

	/**
	 * Create a menu
	 *
	 * @param string $menu_name  Name of the menu
	 * @param string $template   Location of the template file
	 */
	public function create( $menu_name, $options = array() )
	{
		$nav = new NavigationList($options);

		$this->_store[$menu_name] = $nav;

		$nav->key = $menu_name;

		return $nav;
	}

	/**
	 * Get a navigation list object
	 *
	 * @param string $menu_name Name of the menu
	 */
	public function get( $menu_name )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name];
		}
		else
		{
			return new NavigationList();
		}
	}

	/**
	 * Add a navigation node
	 *
	 * @param string $menu_name Name of the menu this node is placed under
	 * @param array  $args      Node configuration array, refer to Navigationlist::add method
	 */
	public function add( $menu_name,
	                     $args = array() )
	{
		if ( !isset($this->_store[$menu_name]) )
		{
			$this->_store[$menu_name] = new Navigationlist();
		}

		$this->_store[$menu_name]->add($args);

		return $this;
	}

	/**
	 * Update a navigation node
	 *
	 * @param string $menu_name Name of the menu this node is placed under
	 * @param array  $args      Node configuration array, refer to Navigationlist::add method
	 */
	public function update( $menu_name,
	                               $args = array() )
	{
		if ( !isset($this->_store[$menu_name]) )
		{
			$this->_store[$menu_name] = new Navigationlist();
		}

		$this->_store[$menu_name]->update($args);

		return $this;
	}

	/**
	 * Count the number of nodes in this menu
	 */
	public function count( $menu_name )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return count($this->_store[$menu_name]);
		}
		else
		{
			return 0;
		}
	}

	/**
	 * Remove a navigation node
	 *
	 * @param string $menu_name Menu of the node to be removed from
	 * @param string $key       Key that identifies node to be removed
	 */
	public function remove( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			$this->_store[$menu_name]->remove_node($key);
		}

		return $this;
	}

	/**
	 * Attaches another Navigation_List object to specified node
	 *
	 * @param string $menu_name Menu of the node to attach to
	 * @param string $key       Key that identifies node to attach object
	 * @param string $list_obj  Navigation list Object to attach to node
	 */
	public function attach( $menu_name,
	                               $key,
	                               $list_obj )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			$this->_store[$menu_name]->attach($key, $list_obj);
		}

		return $this;
	}

	/**
	 * Detaches Navigation_List object from specified node
	 *
	 * @param string $menu_name Menu of the node to be removed from
	 * @param string $key       Key that identifies node to detach object
	 * @param string $list_obj  Navigation list Object to be detached from node
	 */
	public function detach( $menu_name,
	                               $key,
	                               $list_obj)
	{
		if ( isset($this->_store[$menu_name]) )
		{
			$this->_store[$menu_name]->detach($key, $list_obj);
		}

		return $this;
	}

	/**
	 * Sets a navigation node as being the current active node
	 *
	 * @param string $menu_name Menu of the node to be removed from
	 * @param string $key       Key that identifies node to set as active
	 */
	public function active( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			$this->_store[$menu_name]->active($key);
		}

		return $this;
	}

	public function resetActive( $menu_name )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->resetActive();
		}

		return $this;
	}

	public function inactive( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->inactive($key);
		}

		return $this;
	}

	public function isActive( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->isActive($key);
		}

		return $this;
	}

	/**
	 * Gets the title of a node
	 *
	 * @param string $menu_name Menu of the node where the title resides
	 * @param string $key       Key that identifies node
	 */
	public function title( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->getTitle($key);
		}
		return '';
	}
	/**
	 * Gets the image of a node
	 *
	 * @param string $menu_name Menu of the node where the image resides
	 * @param string $key       Key that identifies node
	 */
	public function image( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->getImage($key);
		}
		return '';
	}

	/**
	 * Gets the html of a node
	 *
	 * @param string $menu_name Menu of the node where the html resides
	 * @param string $key       Key that identifies node
	 */
	public function html( $menu_name, $key )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->getHtml($key);
		}
		return '';
	}

	public function setDefaultRender($menu_name, $renderCallback)
	{
		return $this->_store[$menu_name]->setDefaultRender($renderCallback);
	}

	public function render( $menu_name, $renderCallback = null )
	{

		if ( isset($this->_store[$menu_name]) )
		{
			return $this->_store[$menu_name]->render($renderCallback);
		}
		return '';		
	}

	public function output( $menu_name, $renderCallback = null )
	{
		if ( isset($this->_store[$menu_name]) )
		{
			echo $this->render($menu_name, $renderCallback);
		}
		else
		{
			echo '';
		}
	}
}
?>
