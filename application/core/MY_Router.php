<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * Modify the core routing class to enable a "modular" approach to files.
 *
 * @package		JMC
 * @author		Jose Consador
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Router Class
 *
 * Parses URIs and determines routing
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @author		ExpressionEngine Dev Team
 * @category	Libraries
 * @link		http://codeigniter.com/user_guide/general/routing.html
 */
class MY_Router extends CI_Router {
    private $_module = false;

	// --------------------------------------------------------------------

	/**
	 * Set the route mapping
	 *
	 * This function determines what should be served based on the URI request,
	 * as well as any "routes" that have been set in the routing config file.
	 *
	 * @access	private
	 * @return	void
	 */
	function _set_routing()
	{
		// Are query strings enabled in the config file?  Normally CI doesn't utilize query strings
		// since URI segments are more search-engine friendly, but they can optionally be used.
		// If this feature is enabled, we will gather the directory/class/method a little differently
		$segments = array();
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			if (isset($_GET[$this->config->item('directory_trigger')]))
			{
				$this->set_directory(trim($this->uri->_filter_uri($_GET[$this->config->item('directory_trigger')])));
				$segments[] = $this->fetch_directory();
			}

			if (isset($_GET[$this->config->item('controller_trigger')]))
			{
				$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));
				$segments[] = $this->fetch_class();
			}

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
				$segments[] = $this->fetch_method();
			}
		}

		// Load the routes.php file.
		@include(APPPATH.'config/routes'.EXT);
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;

		unset($route);
		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);

		// Were there any query string segments?  If so, we'll validate them and bail out since we're done.
		if (count($segments) > 0)
		{
			return $this->_validate_request($segments);
		}

		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();

		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			return $this->_set_default_controller();
		}

		// Do we need to remove the URL suffix?
		$this->uri->_remove_url_suffix();

		// Compile the segments into an array
		$this->uri->_explode_segments();

		// Parse any custom routing that may exist
		$this->_parse_routes();

		// Re-index the segment array so that it starts with 1 rather than 0
		$this->uri->_reindex_segments();
	}

	// --------------------------------------------------------------------

	/**
	 * Set the Route
	 *
	 * This function takes an array of URI segments as
	 * input, and sets the current class/method
	 *
	 * @access	private
	 * @param	array
	 * @param	bool
	 * @return	void
	 */
	function _set_request($segments = array())
	{
		$segments = $this->_validate_request($segments);

		if (count($segments) == 0)
		{
			return $this->_set_default_controller();
		}

        if ($this->_set_module_routes($segments))
        {
            return;
        }
        
		$this->set_class($segments[0]);

		if (isset($segments[1]))
		{
			// A standard method request
			$this->set_method($segments[1]);
		}
		else
		{
			// This lets the "routed" segment array identify that the default
			// index method is being used.
			$segments[1] = 'index';
		}

		// Update our "routed" segment array to contain the segments.
		// Note: If there is no custom routing, this array will be
		// identical to $this->uri->segments
		$this->uri->rsegments = $segments;
	}
	
	function set_module($module)
	{
	    $this->_module = $module;
	}
	
	function fetch_module()
	{
	    return $this->_module;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set the routes if the module exists.
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	function _set_module_routes($segments)
	{ 
	    // Is there a module folder named like the requested segment?
		if (file_exists(MODPATH . $segments[0]))
		{
   		    $this->set_module($segments[0]);
		    // Is there a controller within the module folder like $segment[1] ?
    		if (count($segments) > 1 AND file_exists(MODPATH. '/' . $segments[0] . '/controllers/' . $segments[1].EXT))
    		{
    		    $this->set_class($segments[1]);
    		}
    		
    		// Is there an index controller?
    		if (file_exists(MODPATH . $segments[0] . '/controllers/index'.EXT))
    		{
    		    $this->set_class('index');
    		}    	
    		
		    if (isset($segments[2]))
		    {
			    // A standard method request
			    $this->set_method($segments[2]);
		    }
		    else
		    {
			    // This lets the "routed" segment array identify that the default
			    // index method is being used.
			    $segments[2] = 'index';
		    }

            $this->uri->rsegments = $segments;		     			

            return TRUE;
		}
		else
		{
		    return FALSE;
		}
    }

	// --------------------------------------------------------------------

	/**
	 * Validates the supplied segments.  Attempts to determine the path to
	 * the controller.
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	function _validate_request($segments)
	{
		if (count($segments) == 0)
		{
			return $segments;
		}

        // Is there a module folder named like the requested segment?
		if (file_exists(MODPATH . $segments[0]))
		{
		    $this->set_module($segments[0]);   
		    // Is there a controller within the module folder like $segment[1] ?
    		if (count($segments) > 1 AND file_exists(MODPATH . $segments[0] . '/controllers/' . $segments[1].EXT))
    		{
    		    return $segments;
    		}

		    // Is the controller in a sub-folder?
		    if (is_dir(MODPATH . $segments[0] . '/' . $segments[1] . '/controllers/'))
		    {    	
			    // Set the directory and remove it from the segment array
			    $this->set_directory($segments[1]);
			    unset($segments[1]);

			    foreach ($segments as $segment)
			    {
			        $n_segments[] = $segment;
			    }			    
			    
                $segments = $n_segments;

			    if (count($segments) > 0)
			    {
				    // Does the requested controller exist in the sub-folder?				   
				    if (!isset($segments[1]) || ! file_exists(MODPATH . $segments[0]. '/' . $this->fetch_directory(). 'controllers/'.$segments[1].EXT))
				    {
				        // Let's try to look for an index controller.
                		if (file_exists(MODPATH . $segments[0] . '/' . $this->fetch_directory(). '/controllers/index'.EXT))
                		{
                		    $this->set_class('index');
                		    return $segments;
                		}   				        
					    show_404($this->fetch_directory().$segments[0]);
				    }
                    
                    $this->set_class($segments[1]);
                    return $segments;				    
			    }
			    else
			    {
				    // Is the method being specified in the route?
				    if (strpos($this->default_controller, '/') !== FALSE)
				    {
					    $x = explode('/', $this->default_controller);

					    $this->set_class($x[0]);
					    $this->set_method($x[1]);
				    }
				    else
				    {
					    $this->set_class($this->default_controller);
					    $this->set_method('index');
				    }

				    // Does the default controller exist in the sub-folder?
				    if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
				    {
					    $this->directory = '';
					    return array();
				    }
			    }
			    
        		// Is there an index controller?
        		if (count($segments) == 2 AND file_exists(MODPATH . $segments[0] .'/' . $this->fetch_directory(). '/controllers/index'.EXT))
        		{
        		    $this->set_class('index');
        		    return $segments;
        		}    			        					    
    		}
    		
    		// Is there an index controller?
    		if (file_exists(MODPATH . $segments[0] . '/controllers/index'.EXT))
    		{
    		    $this->set_class('index');
    		    return $segments;
    		}    		
		}

		// Does the requested controller exist in the root folder?
		if (file_exists(APPPATH.'controllers/'.$segments[0].EXT))
		{
			return $segments;
		}

		// Is the controller in a sub-folder?
		if (is_dir(APPPATH.'controllers/'.$segments[0]))
		{
			// Set the directory and remove it from the segment array
			$this->set_directory($segments[0]);
			$segments = array_slice($segments, 1);

			if (count($segments) > 0)
			{
				// Does the requested controller exist in the sub-folder?
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].EXT))
				{
					show_404($this->fetch_directory().$segments[0]);
				}
			}
			else
			{
				// Is the method being specified in the route?
				if (strpos($this->default_controller, '/') !== FALSE)
				{
					$x = explode('/', $this->default_controller);

					$this->set_class($x[0]);
					$this->set_method($x[1]);
				}
				else
				{
					$this->set_class($this->default_controller);
					$this->set_method('index');
				}

				// Does the default controller exist in the sub-folder?
				if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
				{
					$this->directory = '';
					return array();
				}

			}

			return $segments;
		}

		// If we've gotten this far it means that the URI does not correlate to a valid
		// controller class.  We will now see if there is an override
		if (!empty($this->routes['404_override']))
		{
			$x = explode('/', $this->routes['404_override']);

			$this->set_class($x[0]);
			$this->set_method(isset($x[1]) ? $x[1] : 'index');

			return $x;
		}


		// Nothing else to do at this point but show a 404
		show_404($segments[0]);
	}
	
	// --------------------------------------------------------------------

	/**
	 *  Parse Routes
	 *
	 * This function matches any routes that may exist in
	 * the config/routes.php file against the URI to
	 * determine if the class/method need to be remapped.
	 *
	 * @access	private
	 * @return	void
	 */
	function _parse_routes()
	{
		// Turn the segment array into a URI string
		$uri = implode('/', $this->uri->segments);

		// Is there a literal match?  If so we're done
		if (isset($this->routes[$uri]))
		{
			return $this->_set_request(explode('/', $this->routes[$uri]));
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->routes as $key => $val)
		{
			// Convert wild-cards to RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));

			// Does the RegEx match?
			if (preg_match('#^'.$key.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}

				return $this->_set_request(explode('/', $val));
			}
		}

		// If we got this far it means we didn't encounter a
		// matching route so we'll set the site default route
		$this->_set_request($this->uri->segments);
	}	
}
// END Router Class

/* End of file MY_Router.php */
/* Location: ./application/core/MY_Router.php */
