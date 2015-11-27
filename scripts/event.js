$(document).ready(function() {
	eventBriefEllipsis();
	$(".event #title + a.edit").click(function() {
		$(this).hide();
		editField($(this).prev(), "title");
		return false;
	})
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

function editField(field, name) {
	var value = field.html();

	field.hide();
	field.after('<input class="edit ' + name + '" name="' + name + '" type="text" value="' + value + '" />');
	field.parent().on("keyup", "input.edit." + name, function (e) {
		if (event.keyCode == 13 && !event.shiftKey)
			alert("a");
	});
}