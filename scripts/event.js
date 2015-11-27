$(document).ready(function() {
	eventBriefEllipsis();
});

function eventBriefEllipsis() {
	$('.event_brief p').each(function() {
		var numCharsToShow = 100;
		var content = $(this).html();
		if(content.length > numCharsToShow) {
			var lessContent = content.substr(0, numCharsToShow);
			var moreContent = content.substr(numCharsToShow, content.length - numCharsToShow);
			var newContent = lessContent;
			newContent += '<span class="ellipsis">...</span><span class="more_content"><span>';
			newContent += moreContent;
			newContent += '</span>&nbsp;<a href="" class="more_link">more</a></span>';
			$(this).html(newContent);
		}
	});

	$(".more_link").click(function(){
		$(this).parent().prev().toggle(); // .ellipsis span
		$(this).prev().toggle(); // .moreContent span

		if($(this).hasClass("less")) { // Retract
			$(this).removeClass("less");
			$(this).html("more");
		} else { // Expand
			$(this).addClass("less");
			$(this).html("less");
		}
		return false;
	});
}