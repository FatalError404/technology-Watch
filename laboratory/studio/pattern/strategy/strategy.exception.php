<?php
	namespace laboratory\studio\pattern\strategy;
	use Exception;
	class TemplateException extends Exception{
		const DIR_ERR_CODE = 0;
		const FILE_ERR_CODE = 1;
		/**
		 * @fn public function __construct()
		 */
		public function __construct( $message, $code ){
			switch ( $code ) {
				case self::DIR_ERR_CODE:
					$this->message = 'Error on line '. $this->getLine() .' in '. $this->getFile() . ': The directory '. $message . ' does not exist.' ;
					break;
				
				case self::FILE_ERR_CODE:
					$this->message = 'Error on line '. $this->getLine() .' in '. $this->getFile() . ': The file '. $message . ' does not exist.' ;
					break;
			}
		}
	}
?>