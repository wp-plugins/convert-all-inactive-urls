<?php
if(!class_exists('Convert_All_Inactive_URLS_In_Post'))
{
	class Convert_All_Inactive_URLS_In_Post
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// register actions
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
            // hook the_content
            add_filter( 'the_content', array(&$this, 'make_clickable') );
		} // END public function __construct
		
        // add http:// if not exist
        public function addhttp($url,$addhttp=true) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                if(!preg_match('/^[a-zA-Z0-9]+$/i', substr($url, -1))){
                    $url = substr($url, 0, -1);
                }
                if(!$addhttp)
                    return $url;
                $url = "http://" . trim($url);
            }
            return $url;
        }

        // create clickable content function
        public function make_clickable($text) {
            $regex = array(
                '# [-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si',
                '#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)? #si',
                );
            $the_content = preg_replace_callback($regex, function($matches) {
                return $this->anchor($matches[0]);
            }, $text);
            $arr_match = array(
                '</a>'  => '</a> ',
                ' </a>' => '</a> ',
                '</a>  '=> '</a> ',
                '</a> .'=> '</a>.',
                '<a'    => ' <a',
                '  <a'  => ' <a',
                );
            $the_content = str_replace(array_keys($arr_match), array_values($arr_match), $the_content);
            return trim($the_content);
        }

        // create anchor
        public function anchor($url)
        {
            $the_link = $this->addhttp($url); // add http if not exist
            $block_domain = get_option($this->metakey('block_domain')); // block_domain
            if($block_domain){
                $arr_blocked = explode("\n", $block_domain);
                foreach ($arr_blocked as $key => $domain) {
                    $domain = preg_replace("/[^A-Za-z0-9.]/", '', $domain);
                    if(strpos($url, $domain)!==false){
                        return $url;
                    }
                }
            }
            $nofollow = get_option($this->metakey('nofollow')); // nofollow setting
            $target = get_option($this->metakey('target')); // target attribute setting
            $the_anchor = "<a href=\"{$the_link}\"";
            $the_anchor .= $nofollow ? "rel=\"{$nofollow}\" " : "rel=\"{$nofollow}\" ";
            $the_anchor .= $target ? "target=\"{$target}\" " : "target=\"_blank\" ";
            $the_anchor .= ">".trim($url)."</a>";
            return $the_anchor;
        }
        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
        	// register your plugin's settings
        	register_setting('wp_plugin_template-group', $this->metakey('nofollow'));
            register_setting('wp_plugin_template-group', $this->metakey('target'));
        	register_setting('wp_plugin_template-group', $this->metakey('block_domain'));

        	// add your settings section
        	add_settings_section(
        	    'wp_plugin_template-section', 
        	    'Settings', 
        	    array(&$this, 'settings_section_wp_plugin_template'), 
        	    'wp_plugin_template'
        	);
        	
            // Follow link fields
            add_settings_field(
                'wp_plugin_template-'.$this->metakey('nofollow'), 
                'Follow link', 
                array(&$this, 'settings_field_input_text'), 
                'wp_plugin_template', 
                'wp_plugin_template-section',
                array(
                    'field' => $this->metakey('nofollow')
                )
            );

        	// Target attribute
            add_settings_field(
                'wp_plugin_template-'.$this->metakey('target'), 
                'Target attribute', 
                array(&$this, 'settings_field_input_text'), 
                'wp_plugin_template', 
                'wp_plugin_template-section',
                array(
                    'field'     => $this->metakey('target'),
                    'options'   => array(
                        '_blank'    => 'Opens the linked document in a new window or tab',
                        '_self'     => 'Opens the linked document in the same frame as it was clicked (this is default)',
                        '_parent'   => 'Opens the linked document in the parent frame',
                        '_top'      => 'Opens the linked document in the full body of the window'
                        )
                )
            );

            // Block domain
            add_settings_field(
                'wp_plugin_template-'.$this->metakey('block_domain'), 
                'Block domain', 
                array(&$this, 'settings_field_input_text'), 
                'wp_plugin_template', 
                'wp_plugin_template-section',
                array(
                    'field' => $this->metakey('block_domain')
                )
            );
            // Possibly do additional admin_init tasks
        } // END public static function activate

        public function metakey($key){
            return 'mclickable_'. $key;
        }
        
        public function settings_section_wp_plugin_template()
        {
            // Think of this as help text for the section.
            echo 'This plugin will convert the entire inactive urls becomes active urls as links. This means that only the entire inactive urls which will be converted into an active url. You also can set up unwanted domains that will not be converted as links and display as normal text.';
        }
        
        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo the field
            if($field===$this->metakey("nofollow")){
                $checked = ($value==="nofollow") ? 'checked' : '';
                echo sprintf('<label><input type="checkbox" name="%s" id="%s" value="nofollow" %s />Nofollow</label>', $field, $field, $checked);
            } else if($field===$this->metakey("target")){
                $options = $args['options'];
                // if not yet choose default is _blank
                $value = ($value) ? $value : '_blank';
                foreach ($options as $opt_value => $description) {
                    $checked = ($value===$opt_value) ? 'checked' : '';
                    echo sprintf('<label><input type="radio" name="%s" value="%s" %s /><strong>%s</strong> (<em>%s</em>)</label><br/>', $field, $opt_value, $checked, $opt_value, $description);
                }
            } else {
                echo sprintf('<textarea placeholder="Ex : spamdomain.com" rows="8" style="width:350px;" name="%s" id="%s">%s</textarea>', $field, $field, $value);
                echo "<p><strong>Note</strong> : one domain per line. When url contain blocked domain, it will not converted as a link.</p>";
            }
        } // END public function settings_field_input_text($args)
        
        /**
         * add a menu
         */		
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'Convert All Inactive URLS', 
        	    'Convert All Inactive URLS', 
        	    'manage_options', 
        	    'convert_inactive_url', 
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()
    
        /**
         * Menu Callback
         */		
        public function plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}
	
        	// Render the settings template
        	include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
        } // END public function plugin_settings_page()
    } // END class Convert_All_Inactive_URLS_In_Post
} // END if(!class_exists('Convert_All_Inactive_URLS_In_Post'))
