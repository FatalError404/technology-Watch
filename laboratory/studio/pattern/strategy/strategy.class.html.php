<?php
	namespace laboratory\studio\pattern\strategy;
	include_once('../parser/template.parser.php') ;
	use laboratory\studio\pattern\parser\TemplateParser;
	/**
	 * @class HTML
	 */
	class HtmlFactory{
		const CACHE_DIR = 'cache';
		protected $cachefile = '';
		protected $content = '';
		/**
		 * @fn parse( $object, $filename )
		 */
		protected function parse( $object, $filename ){
			$this->cachefile = self::CACHE_DIR . '/' . md5( serialize( $object ) . $filename ) . '.php' ;
			if( $this->cacheExist() && $this->cacheSizeOk( $object, $filename ) ){
				$this->content = $this->getCache() ;
			}else{
				$this->cacheTemplate() ;
			}
			include_once( $this->cachefile  ) ;
		}
		/**
		 * @fn cacheExist( $object, $filename )
		 */
		private function cacheExist(){
			return file_exists( $this->cachefile ) ;
		}
		/**
		 * @fn getCache( $object, $filename )
		 */
		private function getCache(){
			return file_get_contents( $this->cachefile  ) ;
		}
		/**
		 * @fn buildTemplate( $object, $filename )
		 */
		private function buildTemplate( $object, $filename ){
			$parser = new TemplateParser( $object ) ;
			return $parser->parse( file_get_contents( $filename ) ) ;
		}
		/**
		 * @fn cacheTemplate( $object, $filename )
		 */
		private function cacheTemplate(){
			$fopen = fopen(  $this->cachefile, 'w+' ) ;
			fwrite( $fopen, $this->content ) ;
			fclose( $fopen ) ;
		}
		/**
		 * @fn private cacheSizeOk()
		 */
		private function cacheSizeOk( $object, $filename ){
			$this->content = $this->buildTemplate( $object, $filename ) ;
			return strnatcmp ( $this->content, $this->getCache() ) === 0 ;
		}
	}
?>