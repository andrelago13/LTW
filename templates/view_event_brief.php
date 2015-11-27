<?php
require_once (__DIR__ . "/../config.php");
require_once (TEMPLATES_PATH . "/utils.php");
require_once (INCLUDES_PATH . "/authentication.php");
require_once (INCLUDES_PATH . "/events.php");
require_once (DATABASE_PATH . "/events.php");
function showEventBrief($idEvent) {
	if (! isUserLoggedIn ())
		throw new RuntimeException ( "You need to be logged in." );
	if (! canSeeEvent ( $_SESSION ["userid"], $idEvent ))
		throw new RuntimeException ( "You do not have access to this event." );
	
	$event = getEvent ( $idEvent );
	echo '<div class="event_brief" id="event' . $idEvent . '">';
	
	echo '<div class="name">';
	echo '<h2>' . htmlspecialchars ( $event ["name"] ) . '</h1>';
	echo '</div>';
	
	echo '<img src="database/event_image.php?id=' . $idEvent . '" alt="' . htmlspecialchars ( $event ["name"] ) . '" width="64" height="64" />';
	
	echo '<div class="description">';
	echo '<p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque urna quam, egestas at ligula ut, pulvinar feugiat magna. Curabitur euismod rutrum neque id eleifend. Aenean quis finibus mauris, mollis scelerisque lectus. Vivamus consectetur gravida condimentum. Nulla ex neque, mattis ut blandit nec, molestie id elit. Aenean non porttitor urna, id ultricies est. Praesent posuere et nibh sit amet pulvinar. Vivamus quis facilisis velit.

Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam efficitur arcu sit amet sodales blandit. Pellentesque luctus massa sodales, lobortis nulla id, dapibus ligula. Quisque consectetur arcu dolor, eu scelerisque tellus mattis id. Vestibulum sollicitudin sem in mi iaculis, id sollicitudin dui condimentum. Proin in vehicula tellus. Sed feugiat vehicula pulvinar. Phasellus nisi turpis, viverra at commodo at, cursus quis quam. Donec quis velit massa. Nam porta blandit purus, non accumsan sapien varius ac. Vivamus luctus vitae nisi id mollis. Cras ultricies diam quam, ac fringilla ligula rhoncus at.

Mauris facilisis rutrum feugiat. Praesent vel sem at nunc posuere sagittis sed quis ligula. Aliquam pulvinar, elit nec ullamcorper tincidunt, massa urna laoreet lorem, vitae ullamcorper diam sem eu enim. Duis ullamcorper neque in odio fringilla tempor. Nulla commodo turpis at lacus porta, vel egestas leo mattis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas molestie porta nunc, a accumsan sem maximus a. Nam vitae pretium sapien. Vivamus sit amet volutpat massa. Etiam id justo tellus. Morbi dapibus, mi eu hendrerit rhoncus, lectus lorem molestie arcu, sed eleifend erat augue non arcu. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Morbi sed mollis ipsum. Phasellus vehicula id erat nec condimentum. Aliquam hendrerit nulla non egestas ultrices.

Vivamus consequat aliquet mi ac commodo. Integer faucibus augue sit amet maximus lobortis. Sed sapien diam, lacinia quis dolor et, tincidunt facilisis turpis. Sed ante nunc, bibendum et tempor non, auctor vel lectus. Sed sagittis magna a eros venenatis, non laoreet metus maximus. Cras nec pellentesque massa. Nam eget purus sed ex aliquet pretium. Sed at feugiat nisi. Sed non erat et dui eleifend rhoncus. Etiam sapien enim, suscipit nec placerat a, pharetra vel purus. Praesent non lorem quis ligula tempor fringilla. Vestibulum vitae pellentesque est, id pulvinar quam. Nulla facilisis, mauris cursus maximus consectetur, sem ipsum efficitur orci, vitae molestie orci justo sed augue.

Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vivamus sed arcu magna. Aenean vitae neque sed lacus egestas suscipit id quis lorem. Suspendisse massa eros, dignissim quis leo sed, hendrerit dapibus ante. Phasellus sollicitudin vehicula sapien, sed interdum ante tincidunt eu. Sed ultrices nisi nec nulla blandit rutrum. Ut augue risus, volutpat eget lobortis ut, euismod sit amet ipsum. Aliquam id feugiat massa. Quisque vehicula elementum felis, a convallis nulla placerat hendrerit. Mauris placerat quis tellus ac varius. Mauris sed tortor est. Phasellus imperdiet tristique nibh auctor cursus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla facilisi.</p>';
	echo '</div>';
	
	echo '<datetime>' . htmlspecialchars ( $event ["date"] ) . '</datetime>';
	
	
	echo '</div>';
}

?>
