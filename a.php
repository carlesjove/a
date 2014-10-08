<?php
if ( ! class_exists('A') ) {

	/**
	* A
	* A minimal PHP router based on file naming, for those times you want to keep things simple. 
	* Just name a file like_this.php and you'll get a route http://example.com/like/this. 
	*
	* @author 	Carles Jove i Buxeda
	* @version 	0.5
	* @link 		http://github.com/carlesjove/a
	* @license  MIT License (http://www.opensource.org/licenses/mit-license.php)
	*/
	class A
	{
		public $path;
		public $layout = 'layout';
		protected $request = '404';
		public $current_lang;
		
		public function __construct($path)
		{
			$this->path = $this->ignore_ending_slash( explode('/', $path) );
			$this->layout = $this->as_file($this->layout);
			$this->dispatch();
		}

		protected function find_matches() {
			// Is multilingual ?
			if ( ! empty($this->path[0]) ) { 
				if ( $this->is_multilingual() and $this->language_exists($this->path[0]) ) {
					$this->current_lang = array_shift($this->path);
				}
			}

			if ( ! empty($this->path[0]) ) { 
				if ( $this->is_item_page() ) {
					$file = $this->path[0] . '_' . '[id]';
				} else {
					$file = implode('_', $this->path);
				} 
			} else {
				$file = 'home';
			}

			// Not found
			if ( ! file_exists($this->as_file($file)) ) {
				$file = $this->request;
			}		
			
			if ( file_exists( $this->as_file($file) ) ) {
				$this->request = $this->as_file($file);
			} else { // Not even 404 was found, so raise and Exception
				throw new Exception( "Could not find any file matching " . implode('_', $this->path) );
			}
		}

		protected function is_item_page() {
			return isset( $this->path[1] ) and file_exists( $this->as_file($this->path[0] . '_' . '[id]') );
		}

		protected function as_file($string) {
			return $string . '.php';
		}

		protected function uses_layout() {
			if ( file_exists($this->layout) ) {
				return true;
			}
			return false;
		}

		protected function content() {
			
			$data_directories = array('data/');

			// Include global data
			include $this->global_data();

			// It's multilingual
			if ( $this->is_multilingual() and $this->current_lang ) {
				// Include global data for the current language
				include $this->global_data($this->current_lang);
				// Iclude page content for the current language
				array_push($data_directories, "data/langs/{$this->current_lang}/");
			}

			foreach ( $data_directories as $data ) {
				if ( file_exists($data . $this->request) ) {
					include $data . $this->request;
				}
				if ( $this->is_item_page() and file_exists($this->as_file( $data . $this->path[0])) ) {
					include $this->as_file( $data . $this->path[0] );
					if ( isset($list) and isset($list[$this->path[1]]) ) {
						$item = $list[$this->path[1]];
					}
				}
			}
			
			include $this->request;
		}

		protected function dispatch() {
			try {
				$this->find_matches();

				// Include custom functions
				if ( file_exists( $this->as_file('functions') ) ) {
					include $this->as_file('functions');
				}

				if ( $this->uses_layout() ) {
					include $this->global_data();
					if ( $this->is_multilingual() and $this->current_lang ) {
						include $this->global_data($this->current_lang);
					}
					include $this->layout;
				} else {
					$this->content();
				}	
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		protected function global_data($lang = '') {
			if ( $lang != '' and file_exists( "data/langs/{$lang}/" . $this->as_file('global') ) ) {
				return "data/langs/{$lang}/" . $this->as_file('global');
			} else {
				if ( file_exists('data/' . $this->as_file('global')) ) {
					return 'data/' . $this->as_file('global');
				}
			}
		}

		protected function is_multilingual() {
			if ( is_dir( 'data/langs' ) ) {
				return true;
			}
			return false;
		}

		protected function language_exists($lang) {
			if ( is_dir( "data/langs/{$lang}" ) ) {
				return true;
			}
			return false;
		}

		protected function ignore_ending_slash($array) {
			$last = count($array) - 1;
			if ( empty( $array[$last] ) ) {
				unset($array[$last]);
			}
			return $array;
		}

		public static function generate_htaccess() {
			$htaccess = "<IfModule mod_rewrite.c> \n"
						   . "RewriteEngine On \n"
						   . "RewriteCond %{REQUEST_FILENAME} !-d \n"
						   . "RewriteCond %{REQUEST_FILENAME} !-f \n"
						   . "RewriteRule ^(.*)$ index.php?path=$1 [QSA,L] \n"
							 . "</IfModule>";
			file_put_contents('.htaccess', $htaccess );
		}

		/**
		 Helper methods
		 */

		/**
		 * Nav
		 * Returns an absolute URL for the $item, which will
		 * contain the language if it's multilingual site
		 *
		 * In your layout.php you would use is like this:
		 * <a href="<?php echo $this->nav('my-page'); ?>">My Page</a>
		 * This will return /my-page or /[lang]/my-page
		 */
		public function nav($item) {
			$output = $item;
			if ( $this->current_lang ) {
				$output = $this->current_lang . '/' . $item;
			}
			return '/' . $output;
		}

		/**
		 * Lang
		 * Returns the current page link for the requested language
		 *
		 * In your layout.php you would use is like this:
		 * <a href="<?php echo $this->lang('ca'); ?>">Català</a>
		 * This will return /ca/[current-page]
		 */
		public function lang($lang) {
			return '/' . $lang . '/' . implode('/', $this->path);
		}
	}

}