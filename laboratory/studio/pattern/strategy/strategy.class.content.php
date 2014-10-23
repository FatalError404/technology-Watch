<?php
	namespace laboratory\studio\pattern\strategy;
	/**
	 * @class Content
	 */
	class Content{
		public $title;
		public $description;
		public $content;
		public $objects;
		public $url;
		/**
		 * @fn __construct
		 */
		public function __construct( $title = '', $description = '', $content = '', $objects = array(), $url = '' ){
			$this->title = $title;
			$this->description = $description;
			$this->content = $content;
			$this->objects = $objects;
			$this->url = $url;
		}
		/**
		 * @fn children()
		 */
		public function children(){
			return $this->objects;
		}
	}
?>