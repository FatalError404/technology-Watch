<?php
	/**
	 * @class HTML
	 * @brief repository class constant to display some html tags
	 */
	class Html{
		const TAG_START = '<';
		const TAG_END   = '>';
		const QUOTE     = '"';
		// separator / delimiter
		const SEPARATOR = '<br />';
		const DELIMITER = '<hr />';
		// header
		const HEADER1_S = '<h1>';
		const HEADER1_E = '</h1>';
		const HEADER2_S = '<h2>';
		const HEADER2_E = '</h2>';
		const HEADER3_S = '<h3>';
		const HEADER3_E = '</h3>';
		const HEADER4_S = '<h4>';
		const HEADER4_E = '</h4>';
		const HEADER5_S = '<h5>';
		const HEADER5_E = '</h5>';
		const HEADER6_S = '<h6>';
		const HEADER6_E = '</h6>';
		// link
		const LINKHRF_S = '<a';
		const LINKHRF_H = ' href="';
		const LINKHRF_E = '</a>';
		// paragraph
		const PARAGRA_S = '<p>';
		const PARAGRA_E = '</p>';
		// attribute
		const ATT_TITLE = ' title="';
	}
	/**
	 * @interface iStudioPatternStrategyInterface
	 * @brief kernel of the Strategy design pattern
	 */
	interface iStudioPatternStrategyInterface{
		// define methods to interface in the different strategy implementors
		public function render( $object ) ;
	}
	/**
	 * @class Full
	 * @brief extend Html class to use html tags as output
	 * @implement iStudioPatternStrategyInterface interface
	 */
	class Full extends Html implements iStudioPatternStrategyInterface {
		/**
		 * @fn render( $object )
		 */
		public function render( $object ){
			return 	self::HEADER1_S . 
					$object->title . 
					self::HEADER1_E . 
					self::SEPARATOR . 
					self::PARAGRA_S . 
					$object->description . 
					self::PARAGRA_E . 
					self::SEPARATOR . 
					$object->content ;
		}
	}
	/**
	 * @class Line
	 * @brief extend Html class to use html tags as output
	 * @implement iStudioPatternStrategyInterface interface
	 */
	class Line extends Html implements iStudioPatternStrategyInterface {
		/**
		 * @fn render( $object )
		 * @brief the render function implements object attribute according to the Content class below
		 * @brief develop your own output using your content class ( from your solution )
		 */
		public function render( $object ){
			$output = 	self::HEADER1_S . 
						$object->title . 
						self::HEADER1_E . 
						self::SEPARATOR . 
						self::PARAGRA_S . 
						$object->description . 
						self::PARAGRA_E . 
						self::SEPARATOR . 
						self::DELIMITER ;
			foreach( $object->children() as $child ){
				$output .= 	self::LINKHRF_S .
							self::LINKHRF_H .
							$child->url .
							self::QUOTE .
							self::ATT_TITLE .
							$child->title . 
							self::QUOTE . 
							self::TAG_END .
							$child->title . 
							self::LINKHRF_E .
							self::SEPARATOR . 
							$child->description . 
							self::DELIMITER ;
			}
			return $output ;
		}
	}
	/**
	 * @class Template
	 * @brief strategy handler class
	 * @breif instance function to construct instance ( similar factory design pattern )
	 */
	class Template{
		private $iStudioPatternStrategyInterface;
		/**
		 * @fn __construct
		 */
		public function __construct( iStudioPatternStrategyInterface $iStudioPatternStrategyInterface ){
			$this->iStudioPatternStrategyInterface = $iStudioPatternStrategyInterface;
		}
		/**
		 * @fn static instance
		 * @brief factory instance function
		 */
		public static function instance( $type ){
			$instance = null;
			switch( $type ){
				case 'full':
					$instance = new self( new Full() );
				break;
				case 'line':
					$instance = new self( new Line() );
				break;
			}
			return $instance;
		}
		/**
		 * @fn render( $object )
		 */
		public function render( $object ){
			return $this->iStudioPatternStrategyInterface->render( $object );
		}
	}
	/**
	 * @class Content
	 * @brief here used for the test, normally using any solution you have your own system content class
	 * @brief using your own system objects, you will have to develop the Full and Line class according to them.
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
		 * @brief fetch objects collection
		 */
		public function children(){
			return $this->objects;
		}
	}
	/**
	 * @test
	 * @brief set some content obect for test
	 * @brief implement the Template Factory Strategy
	 */
	$titre = 'Article Title';
	$description = 'Article Description';
	$content =  Html::PARAGRA_S . 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis commodi ipsum perferendis a corporis nihil amet enim, deserunt earum repellendus neque! Nihil dolore doloribus et explicabo, eaque voluptatibus aspernatur obcaecati?' . Html::PARAGRA_E ;
	$url = '//google.com';
	$object = new Content( $titre, $description, $content, null, $url );
	// here is the concrete developement: instaciation of a Template object using the full strategy
	$template = Template::instance( 'full' );
	echo $template->render( $object );
	echo Html::DELIMITER;
	$titre = 'Folder Title';
	$description = 'Folder Description';
	$objects = array( $object, $object, $object );
	$object = new Content( $titre, $description, $content, $objects );
	// here is the concrete developement: instaciation of a Template object using the line strategy
	$template = Template::instance( 'line' );
	echo $template->render( $object ) ;
?>