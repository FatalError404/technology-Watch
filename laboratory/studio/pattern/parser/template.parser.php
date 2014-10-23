<?php
	namespace laboratory\studio\pattern\parser;
	/**
	 * @class TemplateParser
	 */
	class TemplateParser{
		const VAR_SEP_STA = '\{';
		const VAR_SEP_END = '\}';
		const OPE_SEP_STA = '\{%' ;
		const OPE_SEP_END = '%\}' ;
		const OPE_SET_STA = 'set' ;
		const OPE_LOOP_STA = 'for' ;
		const OPE_LOOP_END = 'endfor' ;
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
						"\b(.+".self::OBJ_SYNTAX_OBJECT.")|".
						self::OPE_SEP_STA."{1}|".
						self::OPE_SEP_END."{1}|".
						"\b(".self::OPE_SET_STA." .+){1}|".
						"\b(".self::OPE_LOOP_STA." .+){1}|".
						"\b(".self::OPE_LOOP_END."){1}".
					"#" ;
		}
		/**
		 * @fn private  phpGenerator( $matches )
		 */
		private function phpGenerator( $matches ){
			$string_result = '' ;
			switch( $matches[0] ){
				case 	strstr( $matches[0], '.' ) !== false &&
						strstr( $matches[0], self::OPE_SET_STA ) === false &&
						strstr( $matches[0], self::OPE_LOOP_STA ) === false &&
						strstr( $matches[0], self::OPE_LOOP_END ) === false:
					$arr_string = explode( '.', $matches[0] ) ;
					$string_result .= '$' . $arr_string[0] ;
					foreach( $arr_string as $index => $string ){
						if( $index > 0 ){
							$string_result .= '->' . $string ;
						}
					}
					break;
				case '{{':
					$string_result .= '<?php echo' ;
					break;
				case '}}':
					$string_result .= ' ; ?>' ;
					break;
				case '{%':
					$string_result .= '<?php ' ;
					break;
				case '%}':
					$string_result .= ' ?>' ;
					break;
				case strstr( $matches[0], self::OPE_SET_STA ) !== false:
					$arr_string = explode( ' ', $matches[0] ) ;
					break;
				case 	strstr( $matches[0], self::OPE_LOOP_STA ) !== false && 
						strstr( $matches[0], self::OPE_LOOP_END ) === false :
					$arr_string = explode( ' ', $matches[0] ) ;
					$string_result .= 'foreach( $' . $arr_string[3] . ' as $' . $arr_string[1] . '){ ?>' ;
					break;
				case strstr( $matches[0], self::OPE_LOOP_END ) !== false:
					$string_result .= '}';
					break;
				
			}
			return $string_result ;
		}
	}
?>