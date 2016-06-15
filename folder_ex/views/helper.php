<?php
/*
Helper functions for Widgetkit 2 plugins.
Author: Ramil Valitov
E-mail: ramilvalitov@gmail.com
Web: http://www.valitov.me/
*/

//If $firstName=true, then returns first name of the current user or empty string if the first name is unkown
//If $firstName=false, then returns second name of the current user or empty string if the second name is unkown
//$widgetkit_user - is parameter that must be set to $app['user'] upon call.
function extractWKUserName($widgetkit_user,$firstName=true){
	$name=trim($widgetkit_user->getName());
	//There is a bug in Widgetkit - it doesn't get the name of the user
	if (!$name){
		//For Joomla:
		if (IsJoomlaInstalled()) {
			$user=JFactory::getUser($widgetkit_user->getId());
			if ($user)
				$name=$user->name;
		}
		//TODO: add equivalent approach for WP
	}
	$split_name=explode(' ',$name);
	if ($firstName)
		 return ((sizeof($split_name)>0)?$split_name[0]:$name);
	@array_shift($split_name);
	return ((sizeof($split_name)>0)?implode(' ',$split_name):'');
}

//Returns true, if the current CMS is Joomla
function IsJoomlaInstalled(){
	return ( (class_exists('JURI')) && (method_exists('JURI','base')) );
}

//Returns true, if it's a valid accessable URL
function url_exists($url) {
    if (!$fp = curl_init($url)) return false;
    return true;
}

//Returns Joomla version or empty string if failed
function getJoomlaVersion(){
	$f=@file_get_contents(__DIR__ .'/../../../../../../../libraries/cms/version/version.php',false,null,0,3400);
	if (!$f)
		return "";

	if (preg_match_all("@.*public\s+\\\$RELEASE\s*=\s*'.+';@",$f,$matches))
		$v.=explode("'",$matches[0][0],3)[1];
	if (preg_match_all("@.*public\s+\\\$DEV_LEVEL\s*=\s*'.+';@",$f,$matches))
		$v.='.'.explode("'",$matches[0][0],3)[1];
	if (preg_match_all("@.*public\s+\\\$DEV_STATUS\s*=\s*'.+';@",$f,$matches))
		$v.=' '.explode("'",$matches[0][0],3)[1];
	if (preg_match_all("@.*public\s+\\\$CODENAME\s*=\s*'.+';@",$f,$matches))
		$v.=' '.explode("'",$matches[0][0],3)[1];
	return trim($v);
}

//Returns WordPress version or empty string if failed
function getWPVersion(){
	$f=@file_get_contents(__DIR__ .'/../../../../../../../wp-includes/version.php',false,null,0,1400);
	if (!$f)
		return "";
	
	if (preg_match_all("@.*\\\$wp_version\s*=\s*'.+';@",$f,$matches))
		$v.=explode("'",$matches[0][0],3)[1];
	return trim($v);
}

//Returns Widgetkit version or empty string if failed
function getWKVersion(){
	$f=@file_get_contents(__DIR__ .'/../../../../config.php',false,null,0,1400);
	if ( (!$f) || (!preg_match_all("@.*'version'\s+=>\s+'.+',@",$f,$matches)) )
		return "";
	return explode("'",$matches[0][0],5)[3];
}

//Returns array with info about current plugin (no matter if it's a widget or a content provider). It works only for custom plugins that are created with updater.js file.
//The array contains following fields:
//name - the name of the plugin or empty string if unknown.
//version - the version of the plugin or empty string if unkown.
//codename - the name of the distro (codename)
function getWKPluginInfo($htmlencode=true){
	$info=[
		'name'=>'',
		'version'=>'',
		'codename'=>''
	];
	
	//A simple way is to parse the updater.js file that contains all the required info
	$f=@file_get_contents(__DIR__ .'/../assets/updater.js',false,null,0,1400);
	if ($f){
		if (preg_match_all("@.*var\s+widget_name\s*=\s*'.+';@",$f,$matches)){
			$info['name']=explode("'",$matches[0][0],3)[1];
			if ($htmlencode)
				$info['name']=htmlspecialchars($info['name']);
		}
		if (preg_match_all("@.*var\s+widget_version\s*=\s*'.+';@",$f,$matches)){
			$info['version']=explode("'",$matches[0][0],3)[1];
			if ($htmlencode)
				$info['version']=htmlspecialchars($info['version']);
		}
		if (preg_match_all("@.*var\s+distr_name\s*=\s*'.+';@",$f,$matches)){
			$info['codename']=explode("'",$matches[0][0],3)[1];
			if ($htmlencode)
				$info['codename']=htmlspecialchars($info['codename']);
		}
	}
	return $info;
}

//Prints information for the "About" section of the plugin
//$appWK - is parameter that must be set to $app upon call.
function printAboutInfo($appWK){
	$versionWK=htmlspecialchars((isset($appWK['version']))?$appWK['version']:'Unknown');
	$versionDB=htmlspecialchars((isset($appWK['db_version']))?$appWK['db_version']:'Unknown');
	$info=getWKPluginInfo();
	$php_version=htmlspecialchars(@phpversion());
	$phpinfo;
	if (version_compare('5.3',$php_version)>0)
		$phpinfo='<span  data-uk-tooltip class="uk-text-danger" style="margin-top: 5px;" title="{{ \'Your PHP is too old! Upgrade is strongly recommended! This plugin may not work with your version of PHP.\' |trans}}"><i class="uk-icon-warning  uk-margin-small-right"></i>'.$php_version.'</span>';
	else
	if (version_compare('5.6',$php_version)>0)
		$phpinfo='<span  data-uk-tooltip class="uk-text-warning" style="margin-top: 5px;" title="{{ \'Your PHP is quite old. Although this widget can work with your version of PHP, upgrade is recommended to the latest stable version of PHP.\' |trans}}"><i class="uk-icon-warning  uk-margin-small-right"></i>'.$php_version.'</span>';
	else
		$phpinfo='<span  data-uk-tooltip class="uk-text-success" style="margin-top: 5px;" title="{{ \'Your PHP version is OK.\' |trans}}"><i class="uk-icon-check uk-margin-small-right"></i>'.$php_version.'</span>';

	$wkinfo;
	if (version_compare('2.5.0',$versionWK)>0)
		$wkinfo='<span  data-uk-tooltip class="uk-text-danger" style="margin-top: 5px;" title="{{ \'Your Widgetkit version is too old. Upgrade is strongly recommended. Although this plugin may work with your version of Widgetkit, upgrade is recommended to the latest stable version of Widgetkit.\' |trans}}"><i class="uk-icon-warning uk-margin-small-right"></i>'.$versionWK.'</span>';
	if (version_compare('2.6.0',$versionWK)>0)
		$wkinfo='<span  data-uk-tooltip class="uk-text-warning" style="margin-top: 5px;" title="{{ \'Your Widgetkit version is quite old. Although this plugin may work with your version of Widgetkit, upgrade is recommended to the latest stable version of Widgetkit.\' |trans}}"><i class="uk-icon-warning uk-margin-small-right"></i>'.$versionWK.'</span>';
	else
		$wkinfo='<span  data-uk-tooltip class="uk-text-success" style="margin-top: 5px;" title="{{ \'Your Widgetkit version is OK.\' |trans}}"><i class="uk-icon-check uk-margin-small-right"></i>'.$versionWK.'</span>';
	
	if (!isset($info['codename'])){
		echo <<< EOT
<div class="uk-panel uk-panel-box uk-alert uk-alert-danger"><i class="uk-icon uk-icon-warning uk-margin-small-right"></i>{{ 'Failed to retrieve information' |trans}}</div>;
EOT;
		return;
	}
	
	echo <<< EOT
<div class="uk-grid">
	<div class="uk-text-center uk-width-medium-1-3" id="logo-{$info['codename']}">
	</div>
	<div class="uk-width-medium-2-3">
		<table class="uk-table uk-table-striped">
			<tr>
				<td>
					{{ 'Plugin Name' |trans}}
				</td>
				<td id="name-{$info['codename']}">
					N/A
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Plugin Version' |trans}}
				</td>
				<td id="version-{$info['codename']}">
					N/A
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Plugin Build Date' |trans}}
				</td>
				<td id="build-{$info['codename']}">
					N/A
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Widgetkit Version' |trans}}
				</td>
				<td id="version-wk-{$info['codename']}">
					{$wkinfo}
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Database Version' |trans}}
				</td>
				<td id="version-db-{$info['codename']}">
					{$versionDB}
				</td>
			</tr>
			<tr>
				<td>
					{{ 'jQuery Version' |trans}}
				</td>
				<td id="version-jquery-{$info['codename']}">
					Unknown
				</td>
			</tr>
			<tr>
				<td>
					{{ 'UIkit Version' |trans}}
				</td>
				<td id="version-uikit-{$info['codename']}">
					Unknown
				</td>
			</tr>
			<tr>
				<td>
					{{ 'AngularJS Version' | trans}}
				</td>
				<td id="version-angularjs-{$info['codename']}">
					Unknown
				</td>
			</tr>
			<tr>
				<td>
					{{ 'PHP Version' | trans}}
				</td>
				<td>
					{$phpinfo}
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Author' |trans}}
				</td>
				<td>
					<a href="https://valitov.me" target="_blank">{{ 'Ramil Valitov' |trans}}<i class="uk-icon uk-icon-external-link uk-margin-small-left"></i></a>
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Website' |trans}}
				</td>
				<td id="website-{$info['codename']}">
					N/A
				</td>
			</tr>
			<tr>
				<td>
					{{ 'Wiki and Manuals' |trans}}
				</td>
				<td id="wiki-{$info['codename']}">
					N/A
				</td>
			</tr>
		</table>
		<div id="update-{$info['codename']}">
			<div id="update-available-{$info['codename']}" class="uk-panel uk-panel-box uk-alert-danger uk-text-center update-info-{$info['codename']} uk-hidden">
				<h3 class="uk-text-center">
					<i class="uk-icon uk-icon-warning uk-margin-small-right"></i>{{ 'This plugin is outdated!' |trans}}
				</h3>
				<h4 class="uk-text-center">
					{{ 'A new version is available. Please, update.' |trans}}
				</h4>
				<button type="button" class="uk-button" onclick="var modal = UIkit.modal('#update-modal-{$info['codename']}'); if ( !modal.isActive() ) modal.show();"><i class="uk-icon uk-icon-info-circle uk-margin-small-right"></i>{{ 'Update details' |trans}}</button>
			</div>
			<div id="update-ok-{$info['codename']}" class="uk-panel uk-panel-box uk-alert-success uk-text-center update-info-{$info['codename']} uk-hidden">
				<i class="uk-icon uk-icon-check uk-margin-small-right"></i>{{ 'Your version of the plugin is up to date!' |trans}}
			</div>
			<div id="update-problem-{$info['codename']}" class="uk-panel uk-panel-box uk-alert-danger uk-text-center update-info-{$info['codename']} uk-hidden">
				<i class="uk-icon uk-icon-warning uk-margin-small-right"></i>{{ 'Failed to retrieve information about available updates.' |trans}}
			</div>
		</div>
	</div>
</div>

<div id="update-modal-{$info['codename']}" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-modal-header">
			<h1>'{$info['name']}' plugin update details</h1>
		</div>
		<div class="uk-overflow-container">
			<div class="uk-grid">
				<div class="uk-width-1-3 uk-text-center">
					<img id="update-logo-{$info['codename']}" >
				</div>
				<div class="uk-width-2-3">
					<table class="uk-table">
						<tr>
							<th>
								&nbsp;
							</th>
							<th>
								{{ 'Local (installed)' |trans}}
							</th>
							<th>
								{{ 'Remote (available)' |trans}}
							</th>
						</tr>
						<tr>
							<td>
								{{ 'Version' |trans}}
							</td>
							<td id="version-local-{$info['codename']}">
							</td>
							<td id="version-remote-{$info['codename']}">
							</td>
						</tr>
						<tr>
							<td>
								{{ 'Build date' |trans}}
							</td>
							<td id="date-local-{$info['codename']}">
							</td>
							<td id="date-remote-{$info['codename']}">
							</td>
						</tr>
					</table>
				</div>
			</div>
			
			<hr>
			<h2>
				{{ 'Release information:' |trans}}
			</h2>
			<div id="release-info-{$info['codename']}">
			</div>
			<hr>
			<h2>
				{{ 'How to update?' |trans}}
			</h2>
			<div class="uk-grid uk-grid-width-1-2">
				<div class="uk-text-center">
					<a id="download-{$info['codename']}" class="uk-button uk-button-success" target="_blank" href><i class="uk-icon uk-icon-external-link uk-margin-small-right"></i>{{ 'Download Page' |trans}}</a>
				</div>
				<div class="uk-text-center">
					<a id="instructions-{$info['codename']}" class="uk-button" target="_blank" href><i class="uk-icon uk-icon-external-link uk-margin-small-right"></i>{{ 'Instructions' |trans}}</a>
				</div>
			</div>
		</div>
		<div class="uk-modal-footer uk-text-right">
			<button class="uk-button uk-button-primary uk-modal-close">{{ 'Ok' |trans}}</button>
		</div>
	</div>
</div>
EOT;
}

//Prints information for the "Newsletter" section of the plugin with subscribe button
//$appWK - is parameter that must be set to $app upon call.
function printNewsletterInfo($appWK){
	$info=getWKPluginInfo();
	$firstName=htmlspecialchars(extractWKUserName($appWK['user']));
	$lastName=htmlspecialchars(extractWKUserName($appWK['user'],false));
	$email=htmlspecialchars($appWK['user']->getEmail());
	$cms=htmlspecialchars((IsJoomlaInstalled())?'Joomla':'WordPress');
	$origin=htmlspecialchars($appWK['request']->getBaseUrl());
	
	if (!isset($info['codename'])){
		echo <<< EOT
<div class="uk-panel uk-panel-box uk-alert uk-alert-danger"><i class="uk-icon uk-icon-warning uk-margin-small-right"></i>{{ 'Failed to retrieve information' |trans}}</div>;
EOT;
		return;
	}
	
	echo <<< EOT
<div class="uk-panel uk-panel-box uk-alert">
	<p>
		<i class="uk-icon uk-icon-info-circle uk-margin-small-right"></i>{{ 'We have different free products that extend functionality of the Widgetkit. Please, subscribe for a newsletter to get notifications about new releases of the current plugin, other widgets that we create, and news when a completely new product for the Widgetkit becomes available.' | trans}}
	</p>
</div>

<button class="uk-button uk-button-success" data-uk-modal="{target:'#{$info['codename']}-subscribe'}"><i class="uk-icon uk-icon-check uk-margin-small-right"></i>{{ 'Subscribe' |trans}}</button>

<div id="{$info['codename']}-subscribe" class="uk-modal">
	<div class="uk-modal-dialog">
		<a class="uk-modal-close uk-close"></a>
		<div class="uk-overflow-container">
			<div class="uk-panel uk-panel-box uk-alert">
			<i class="uk-icon uk-icon-info-circle uk-margin-small-right"></i>{{ 'Please, fill in all the fields below, then click Submit button' |trans}}
			</div>
			<form class="uk-form uk-form-horizontal" action="http://valitov.us11.list-manage.com/subscribe/post?u=13280b8048b58d2be207f1dd5&amp;id=52d79713c6" method="post" id="form-{$info['codename']}-subscribe" target="_blank">
				<fieldset data-uk-margin>
					<legend>{{ 'Subscription Form' |trans}}</legend>
					<div class="uk-form-row">
						<label class="uk-form-label" for="form-first-name">{{ 'First Name' |trans}}</label>
						<div class="uk-form-controls">
							<input type="text" id="form-first-name" name="FNAME" value="{$firstName}" required="required">
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="form-last-name">{{ 'Last Name' |trans}}</label>
						<div class="uk-form-controls">
							<input type="text" id="form-last-name" name="LNAME" value="{$lastName}" required="required">
						</div>
					</div>
					<div class="uk-form-row">
						<label class="uk-form-label" for="form-email">{{ 'E-mail' |trans}}</label>
						<div class="uk-form-controls">
							<input type="email" id="form-email" name="EMAIL" value="{$email}" required="required">
						</div>
					</div>
					<div style="position: absolute; left: -5000px;" class="uk-hidden">
						<input type="text" name="b_13280b8048b58d2be207f1dd5_52d79713c6" tabindex="-1" value="">
						<input type="text" name="CMS" value="{$cms}">
						<input type="text" name="ORIGIN" value="{$origin}">
						<input type="text" name="PRODUCT" value="{$info['name']}">
					</div>
				</fieldset>
				<div class="uk-text-right uk-margin">
					<button type="button" class="uk-button uk-modal-close">{{'Close'|trans}}</button>
					<button type="submit" class="uk-button uk-button-primary validate">{{'Subscribe'|trans}}</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	jQuery.validate({
		form: '#form-{$info['codename']}-subscribe',
		modules : 'html5',
		errorElementClass: 'uk-form-danger',
		errorMessageClass: 'uk-text-danger',
		validateOnBlur : true,
		scrollToTopOnError : false
	});
	jQuery('#form-{$info['codename']}-subscribe').formchimp();
</script>

EOT;
}
?>