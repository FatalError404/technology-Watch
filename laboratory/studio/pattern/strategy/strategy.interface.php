<?php
	namespace laboratory\studio\pattern\strategy;
	// interface for strategy
	interface iStudioPatternStrategyInterface{
		// define methods to interface in the different strategy implementors
		public function render( $object, $filename ) ;
	}
?>