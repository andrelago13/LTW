$(document).ready(function() {
	eventBriefEllipsis();
	eventInlineEdit();
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

function eventInlineEdit() {
	var name = title;
	$(".event #title + a.edit").click(function() {
		$(this).toggle();
		editTextField($(this).prev(), "title");
		return false;
	})
	$(".event #description + a.edit").click(function() {
		$(this).toggle();
		editTextareaField($(this).prev(), "description");
		return false;
	})
	$(".event #date + a.edit").click(function() {
		$(this).toggle();
		editTextField($(this).prev(), "date");
		return false;
	})
}

function editTextField(field, name) {
	field.hide();
	var newElement = $('<input class="edit ' + name + '" name="' + name + '" type="text" value="' + field.html() + '" />');
	field.after(newElement);
	field.parent().on("keyup", "input.edit." + name, function (e) {
		if (event.keyCode == 13)
		{
			field.show();
			newElement.remove();
			field.next().toggle();
		}
	});
}

function editTextareaField(field, name) {
	field.hide();
	var newElement = $('<textarea class="edit ' + name + '" name="' + name + '" /></textarea>');
	field.after(newElement);
	newElement.val(field.html());
	field.parent().on("keyup", "textarea.edit." + name, function (e) {
		if (event.keyCode == 13 && !event.shiftKey)
		{
			field.show();
			newElement.remove();
			field.next().toggle();
		}
	});
}