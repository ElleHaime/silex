$(document).ready(function ($) {
	$('#myCarousel').carousel({
	    interval: 4000
	});

	$('[id^=carousel-selector-]').click( function(){
	  var id_selector = $(this).attr("id");
	  var id = id_selector.substr(id_selector.length -1);
	  id = parseInt(id);
	  $('#myCarousel').carousel(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $(this).addClass('selected');
	});

	$('#myCarousel').on('slid', function (e) {
	  var id = $('.item.active').data('slide-number');
	  id = parseInt(id);
	  $('[id^=carousel-selector-]').removeClass('selected');
	  $('[id=carousel-selector-'+id+']').addClass('selected');
	});

	$("#carousel-example-generic").carousel();
	$("#myCarousel").carousel();
	$("#carousel-media").carousel();
	$("#carousel-gallery").carousel();
		
	
	calendarEvents = {};
	baseDate = new Date().getFullYear() + '-' + ('0' + (new Date().getMonth()+1)).slice(-2); 
	if (window.genericCalendar !== undefined) {
		for (index = 0; index < window.genericCalendar.length; ++index) {
			wDate = new Date(genericCalendar[index]['start_date']);
			calendarEvents[wDate.getFullYear() + '-' + ('0' + (wDate.getMonth()+1)).slice(-2) + '-' + ('0' + wDate.getDate()).slice(-2)] = 
					{"title": genericCalendar[index]['name'],
					 "url": window.location.origin + '/training/' + genericCalendar[index]['url_name']};
		}
	}
	$(".responsive-calendar").responsiveCalendar({
          time: baseDate,
          events: calendarEvents
    });
});


equalheight = function(container){

	var currentTallest = 0,
	     currentRowStart = 0,
	     rowDivs = new Array(),
	     $el,
	     topPosition = 0;
	 $(container).each(function() {

	   $el = $(this);
	   $($el).height('auto')
	   topPostion = $el.position().top;

	   if (currentRowStart != topPostion) {
	     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
	       rowDivs[currentDiv].height(currentTallest);
	     }
	     rowDivs.length = 0; // empty the array
	     currentRowStart = topPostion;
	     currentTallest = $el.height();
	     rowDivs.push($el);
	   } else {
	     rowDivs.push($el);
	     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
	  }
	   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
	     rowDivs[currentDiv].height(currentTallest);
	   }
	 });
	}

	$(window).load(function() {
	  equalheight('.trainings-item');
	});


	$(window).resize(function(){
	  equalheight('.trainings-item');
	});
