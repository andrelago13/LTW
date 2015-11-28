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
	var name = name;
	$(".event #name + a.edit").click(function() {
		$(this).toggle();
		editTextField($(this).prev(), "name");
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
		validateField(newElement, function() {
			return eventTestname(newElement.val()).length === 0;
		});
		if (event.keyCode == 13)
		{
			var valid = newElement.hasClass('valid');
			if (valid)
				eventUpdateField(field);
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

function eventUpdateField(field) {
	var data = {
			'id' : field.parent().attr('id').substr("event".length, 99999),
	}
	data[field.attr('id')] = field.next().val();
	$.ajax({
		url : "edit_event.php",
		type: "POST",
		data : data,
		success: function(data, textStatus, jqXHR)
		{
			field.html(field.next().val());
			field.show();
			field.next().remove();
			field.next().toggle();
		},
		error: function (jqXHR, textStatus, errorThrown)
		{
			console.error("Error: " + jqXHR.responseText);
		}
	});
}

/*
 * Returns an empty string if name is valid, error message otherwise
 */
function eventTestname(name) {
	if(typeof name == 'undefined')
		return "No name was provided.";

	if(name.length > 100) {
		return "name too large, maximum 100 chars.";
	}

	if(name.length == 0) {
		return "name cannot be empty.";
	}

	return '';
}