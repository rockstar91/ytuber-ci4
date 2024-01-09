function countersReload() {
	$.ajax({
	  dataType: "json",
	  url: '/main/counters',
	  success: function(resp) {
		$('#counter1').html(resp[1]);
		$('#counter2').html(resp[2]);
		$('#counter3').html(resp[3]);
		$('#counter4').html(resp[4]);
	  }
	});
}

// Tooltips for Social Links
$('.tooltip-social').tooltip({
  selector: "a[data-toggle=tooltip]"
})

window.onload = (function () {			
	//var n = $('#contact').offset().top; 
	//$('body').animate({scrollTop:n},1000);
});	

$(document).ready(function() { 
	
	// countersReload();
	//setInterval(function(){countersReload()}, 5000);
	
	
    var optionsContact = { 
        beforeSubmit:  function(formData, jqForm, options) {
			$('.contact-form .status').html('<img src="/static/index/ajax-loader.gif" alt="">');
		},
        success: function(json, statusText, xhr, $form) {

        	console.log(json);
			
			if(json.status == 'success') {
				// очистить форму
				$('.contact-form')[0].reset();
			}
			
			if(typeof json.text != 'undefined') {
				$('.contact-form .status').html(json.text);
			}
			
		}
    }; 
    $('.contact-form').ajaxForm(optionsContact); 
}); 
 

$(document).ready(function($) {
	$('.navbar-nav a').on('click', function(e) {
		e.preventDefault();
		offset = $($(this).attr('href')).offset().top - 80;
		//alert(offset);
		$('body,html').animate({scrollTop:offset}, 1000);
	});
	
	// Подсвечивание ссылок граф. меню при сколлинге страницы
	$(window).scroll(function() {
		var offsetCorrect = $(window).scrollTop();
		var targetPosition = 120;
		$('.anchor').each(function() {		
			if( ( $(this).offset().top - offsetCorrect ) <= targetPosition) {
				$(".navbar-nav a")
				.removeClass('active')
				.filter("[href$='#"+$(this).attr('id')+"']")
				.addClass('active');
			}
		});
	});
});



