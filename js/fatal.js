/* fatal.js */
var Slider = ( function () {
  /**
   * @var instance
   * @brief single instance of the Slider object
   */
  var instance;
  /**
   * @fn init()
   * @brief constructor function
   */
  function init() {
    var clock, delay;
    /**
     * @fn private privateSlide( obj )
     * @brief define the slides jquery objects / define the limit / call the private function privateRecursiveCall
     */
    var privateSlide = function( obj, type ){
      instance.option.type = type ;
      obj.each(function( index ) {
        slides = $(this).find('.slide') ;
        limit = slides.length -1 ;
        effect = instance.option.type ;
        direction = instance.option.direction ;
        privateRecursiveCall( effect, direction, slides, limit );
      });
    };
    /**
     * @fn private privateRecursiveCall( obj, limit )
     * @brief run recursively the lide effect
     */
  	var privateRecursiveCall = function( effect, direction, obj, limit ){
      privateInit( effect, direction, obj, limit ) ;
      clock = delay = 0 ;
  		obj.each(function( index ) {
  			clock = setTimeout(function() {
          slideEffect( effect, direction, obj, $( obj.get( index ) ), index, limit );
  				if( index === limit ){
  					delay = setTimeout( function() {
  						privateRecursiveCall( effect, direction, obj, limit );
              clearTimeout( delay );
  					}, instance.option.duration );
  				}
  			}, instance.option.duration * index );
		  });
  	};
    /**
     * @fn privateInitSlides( obj )
     * @brief on init position slides
     */
    var privateInit = function( effect, direction, obj, limit ){
      switch( effect ){
        case 'slide':
          switch( direction ){
            case 'right':
              privateInitSlideRight( effect, direction, obj, limit );
            break;
            case 'left':
              privateInitSlideLeft( effect, direction, obj, limit );
            break;
          }
        break;
        case 'fade':
          privateInitFade( effect, direction, obj, limit ) ;
        break;
      }
    };
    /**
     * @fn privateInitSlideRight( effect, direction, obj, limit )
     */
    var privateInitSlideRight = function( effect, direction, obj, limit ){
      obj.each(function( index ) {
        if( index > 0 ){
          $(this).css('left', ( $(this).width() ) ) ;
        }
      });
    };
    /**
     * @fn privateInitSlideLeft( effect, direction, obj, limit )
     */
    var privateInitSlideLeft = function( effect, direction, obj, limit ){
      obj.each(function( index ) {
        if( index > 0 ){
          $(this).css('left', -( $(this).width() ) ) ;
        }
      });
    };
    /**
     * @fn privateInitFade( effect, direction, obj, limit 
     */
    var privateInitFade = function( effect, direction, obj, limit ){
      obj.each(function( index ) {
        $(this).hide() ;
      });
    };
    /**
     * @fn private slideEffect
     */
    var slideEffect = function( effect, direction, list, obj, index, limit ){
      switch( effect ){
        case 'slide':
          switch( direction ){
            case 'right':
              slideEffectSlideRight( effect, direction, list, obj, index, limit ) ;
            break;
            case 'left':
              slideSeffectSlideLeft( effect, direction, list, obj, index, limit ) ;
            break;
          }
        break;
        case 'fade':
          slideSeffectFade( effect, direction, list, obj, index, limit ) ;
        break;
      }
    };
    /**
     * @fn slideSeffectSlideLeft( effect, direction, list, obj, index, limit )
     */
    var slideSeffectSlideLeft = function( effect, direction, list, obj, index, limit ){
      obj.toggleClass('current') ;
      previous = obj.prev();
      previous.css('left', -( obj.width() ) ) ;
      if( index < limit ){
        next = obj.next();
        next.toggleClass('current') ;
        next.animate( { left: parseInt( next.css( 'left' ),10 ) == 0 ? -next.outerWidth() : 0 } );
      }else{
        $( list.get( 0 ) ).toggleClass('current') ;
        $( list.get( 0 ) ).animate( { left: 0 } ) ;
      }
    };
    /**
     * @fn slideEffectSlideRight( effect, direction, list, obj, index, limit )
     */
    var slideEffectSlideRight = function( effect, direction, list, obj, index, limit ){
      obj.toggleClass('current') ;
      previous = obj.prev();
      previous.css('left', ( obj.width() ) ) ;
      if( index < limit ){
        next = obj.next();
        next.toggleClass('current') ;
        next.animate( { left: parseInt( next.css( 'left' ),10 ) == 0 ? next.outerWidth() : 0 } );
      }else{
        $( list.get( 0 ) ).toggleClass('current') ;
        $( list.get( 0 ) ).animate( { left: 0 } ) ;
      }
    };
    /**
     * @fn slideSeffectFade( effect, direction, list, obj, index, limit )
     */
    var slideSeffectFade = function( effect, direction, list, obj, index, limit ){
      previous = obj.prev();
      if( index === 0 && $( list.get( limit ) ).hasClass('current') ){
        $( list.get( limit ) ).show();
        $( list.get( limit ) ).removeClass('current');
      }
      if( index > 0 && $( list.get( limit ) ).is(':visible') ){
        $( list.get( limit ) ).hide();
      }
      if( previous.hasClass('current') ){
        previous.removeClass('current');
      }
      if( obj.hasClass('current') === false ){
        obj.addClass('current') ;
      }
      obj.fadeToggle( instance.option.duration, instance.option.easing ) ;
    };
    return {
      /**
       * @var public option
       */
    	option:{type:'slide',duration:1000,direction:'left',easing:'swing'},
      /**
       * @fn public anim( obj )
       * @brief public access to run the slide effect
       */
    	anim: function( obj, type ) {
        return privateSlide( obj, type );
      }
    };
  };
  return {
    /**
     * @fn instance()
     * @brief singleton function to construct the Slider object
     */
    instance: function () {
    	if ( !instance ) {
      	instance = init();
    	}
    	return instance;
    }
  };
})();
$( document ).ready(function() {
	var slider = Slider.instance();
  // to change the duration, set directly the public variable of the current instance
  //slider.option.duration = 3000 ;
  // to change the slide direction, set directly the public variable of the current instance
  //slider.option.direction = 'right' ;
  // to change the fade easing, set directly the public variable of the current instance
  //slider.option.easing = 'linear' ;
	//slider.anim( $('#head_slider'), 'fade' ) ;
  slider.anim( $('#footer_slider'), 'slide' ) ;
});