<?php
	namespace laboratory\studio\pattern\parser;
	/**
	 * @class TemplateParser
	 */
	class TemplateParser{
		const VAR_SEP_STA = '\{';
		const VAR_SEP_END = '\}';
		const OBJ_SYNTAX_OBJECT = '\.' ;
		private $object;
		/**
		 * @fn __construct( $object )
		 */
		public function __construct( $object ){
			$this->object = $object ;
		}
		/**
		 * @fn parse( $rawContent )
		 */
		public function parse( $rawContent ){
			$processedContent = preg_replace_callback( $this->regex( $this->object ), array( $this, 'phpGenerator' ), $rawContent ) ;
			return $processedContent ;
		}
		/**
		 * @fn regex( $object )
		 */
		private function regex( $object ){
			return "#".	self::VAR_SEP_STA."{2}|".
						self::VAR_SEP_END."{2}|".
						"\b(.+".self::OBJ_SYNTAX_OBJECT.")#" ;
		}
		/**
		 * @fn private  phpGenerator( $matches )
		 */
		private function phpGenerator( $matches ){
			$string_result = '' ;
			switch( $matches[0] ){
				case '{{':
					$string_result = '<?php echo' ;
				break;
				case '}}':
					$string_result = ' ; ?>' ;
				break;
				case strstr( $matches[0], '.' ) !== false:
					$arr_string = explode( '.', $matches[0] ) ;
					$string_result = '$' . $arr_string[0] . '->' . $arr_string[1];
				break;
			}
			return $string_result ;
		}
	}
?>