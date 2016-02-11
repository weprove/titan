$(function(){
	Nette.toggle = function (id, visible) {
		var el = $('#' + id);
		var parent = el.parent().parent();
		
		if((el.is("input")||el.is("textarea")||el.is("select"))&&parent.is("tr")){
			if (visible) {
				parent.show();
			} else {
				parent.hide();
			}		
		}
		else if(el.is("label")&&parent.is("tr")){
			if (visible) {
				parent.show();
			} else {
				parent.hide();
			}		
		}
		else if(el.is(":checkbox")){
			if (visible) {
				parent.show();
			} else {
				parent.hide();
			}		
		}
		else{
			if (visible) {
				el.show();
			} else {
				el.hide();
			}
		}
	};
	
	$(".fancybox").fancybox();
	
	$(".fancyvideo").click(function() {
		$.fancybox({
			'padding'		: 0,
			'autoScale'		: false,
			'transitionIn'	: 'none',
			'transitionOut'	: 'none',
			'title'			: this.title,
			'width'			: 640,
			'height'		: 385,
            'href' : this.href.replace(new RegExp('youtu.be', 'i'), 'www.youtube.com/embed').replace(new RegExp('watch\\?v=([a-z0-9\_\-]+)(&|\\?)?(.*)', 'i'), 'embed/$1?version=3&$3'),
			'type'			: 'iframe'
		});

		return false;
	});
	

	$('#jobVacancies').bxSlider({
	minSlides: 1,
	maxSlides: 1,
	slideMargin: 0
	});
	
	// Javascript to enable link to tab
	var url = document.location.toString();
	if (url.match('#')) {
		$('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
	} 
	else{
		if($('.nav-tabs a[href=#home]').length)
			$('.nav-tabs a[href=#home]').tab('show');
	}

	// Change hash for page-reload
	$('.nav-tabs a').on('shown.bs.tab', function (e) {
		e.preventDefault();
		window.location.hash = e.target.hash;
		
		if(!$(this).parent().parent().hasClass('disableScrollTop')){
			$("html, body").scrollTop(0);
		}
	});
	
	$("input.ajax[type=submit]").on('click', function() {
		$('#loader-wrapper').show();
	});
	
	$("body").delegate(".systemDatetime", "focusin", function(){
		$( ".systemDatetime" ).datetimepicker({
				timeFormat: "HH:mm",
				dateFormat: 'dd-mm-yy'
		});	
	});

	$("body").delegate(".systemDate", "focusin", function(){
		$( ".systemDate" ).datepicker({
			dateFormat: 'dd-mm-yy'
		});	
	});
	
	setTimeout(function(){$(".flash").fadeOut("slow")},10000);
});
