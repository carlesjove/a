<?php
if ( ! class_exists('A') ) {

	/**
	* A
	* A minimal PHP router based on file naming, for those times you want to keep things simple. 
	* Just name a file like_this.php and you'll get a route http://example.com/like/this. 
	*
	* @author 	Carles Jove i Buxeda
	* @version 	0.3
	* @link 		http://github.com/carlesjove/a
	* @license  MIT License (http://www.opensource.org/licenses/mit-license.php)
	*/
	class A
	{
		public $path;
		public $layout = 'layout';
		private $request = '404';
		
		function __construct($path)
		{
			$this->path = explode('/', $path);
			$this->layout = $this->as_file($this->layout);
			$this->dispatch();
		}

		private function find_matches() {
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

		private function is_item_page() {
			return isset( $this->path[1] ) and file_exists( $this->as_file($this->path[0] . '_' . '[id]') );
		}

		private function as_file($string) {
			return $string . '.php';
		}

		private function uses_layout() {
			if ( file_exists($this->layout) ) {
				return true;
			}
			return false;
		}

		private function content() {
			if ( file_exists('data/' . $this->request) ) {
				include 'data/' . $this->request;
			}
			if ( $this->is_item_page() and file_exists($this->as_file( 'data/' . $this->path[0])) ) {
				include $this->as_file( 'data/' . $this->path[0] );
				if ( isset($list) and isset($list[$this->path[1]]) ) {
					$item = $list[$this->path[1]];
				}
			}
			include $this->request;
		}

		private function dispatch() {
			try {
				$this->find_matches();
				if ( $this->uses_layout() ) {
					if ( file_exists('data/' . $this->as_file('global')) ) {
						include 'data/' . $this->as_file('global');
					}
					include $this->layout;
				} else {
					include $this->content();
				}	
			} catch (Exception $e) {
				echo $e->getMessage();
			}
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
	}

}