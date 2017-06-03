(function() {
	var hash = location.hash;
	if(hash){
		$('ul.nt').find('li').removeClass('active');
		$('.tp').removeClass('active');

		$(hash).addClass('active');
		$('a[href="'+hash+'"]').parent('li').addClass('active');
	}
})();