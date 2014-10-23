<?php
	namespace laboratory\studio\pattern\strategy;
	include_once('strategy.exception.php') ;
	include_once('strategy.interface.php') ;
	include_once('strategy.class.full.php');
	include_once('strategy.class.line.php');
	/**
	 * @class Template
	 */
	class Template{
		const TEMPLATE_DIR = 'templates' ;
		// define private variable interface !!
		private $iStudioPatternStrategyInterface;
		private $filename;
		/**
		 * @fn __construct
		 */
		public function __construct( iStudioPatternStrategyInterface $iStudioPatternStrategyInterface, $filename ){
			$this->iStudioPatternStrategyInterface = $iStudioPatternStrategyInterface;
			$this->filename = $filename ;
		}
		/**
		 * @fn static instance
		 * @brief factory instance function
		 */
		public static function instance( $type, $filename ){
			$instance = null;
			if( self::checkDir( $type ) ){
				if( self::checkFile( $type, $filename ) ){
					$filename = self::TEMPLATE_DIR . "/$type/$filename" ;
					$instance = self::instanceHandler( $type, $filename ) ;
				}else{
					throw new TemplateException( self::TEMPLATE_DIR . "/$type/$filename", TemplateException::FILE_ERR_CODE ) ;
				}
			}else{
				throw new TemplateException( self::TEMPLATE_DIR . "/$type/", TemplateException::DIR_ERR_CODE ) ;
			}
			return $instance;
		}
		/**
		 * @fn private static instanceHandler( $type )
		 */
		private static function instanceHandler( $type, $filename ){
			$instance = null;
			switch( $type ){
				case 'full':
					$instance = new self( new Full(), $filename );
				break;
				case 'line':
					$instance = new self( new Line(), $filename );
				break;
			}
			return $instance;
		}
		/**
		 * @fn calculate
		 */
		public function render( $object ){
			return $this->iStudioPatternStrategyInterface->render( $object, $this->filename );
		}
		/**
		 * @fn private checkDir( $type )
		 */
		private static function checkDir( $type ){
			return file_exists( self::TEMPLATE_DIR . "/$type" ) && is_dir( self::TEMPLATE_DIR . "/$type" ) ;
		}
		/**
		 * @fn private setFile( $type, $filename )
		 */
		private static function checkFile( $type, $filename ){
			return file_exists( self::TEMPLATE_DIR . "/$type/$filename" ) ;
		}
	}
?>