<?php
	namespace laboratory\studio\pattern\strategy;
	include_once('strategy.interface.php') ;
	include_once('strategy.class.html.php');
	/**
	 * @class Line
	 */
	class Line extends HtmlFactory implements iStudioPatternStrategyInterface {
		/**
		 * @fn render( $object )
		 */
		public function render( $object, $filename ){
			return $this->parse( $object, $filename ) ;
		}
	}
?>