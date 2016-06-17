<?php
/*
FolderEx Content Provider plugin for Widgetkit 2.
Author: Ramil Valitov
E-mail: ramilvalitov@gmail.com
Web: http://www.valitov.me/
Git: https://github.com/rvalitov/widgetkit-folder-ex
*/

require_once(__DIR__.'/helper.php');
?>

<div class="uk-form uk-form-horizontal" ng-controller="folderExCtrl as folder">
    
	<h3 class="wk-form-heading">{{'Content' | trans}}</h3>
	<div class="uk-panel uk-panel-box uk-alert">
		<p><i class="uk-icon uk-icon-info-circle uk-margin-small-right"></i>{{ 'This plugin allows to select image files from a specified folder using sorting and filtering options. These files will be used as content items for the widget you selected.' | trans}}</p>
	</div>

	<div class="uk-form-row">
		<span class="uk-form-label" for="wk-path">{{ 'Folder Path' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="{{ 'The folder where the images are stored. This field is mandatory.' |trans}}"><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
		<div class="uk-form-controls">
			<input id="wk-path" class="uk-form-width-large" type="text" ng-model="content.data['folder']">
		</div>
	</div>

	<div class="uk-form-row">
		<span class="uk-form-label" for="wk-regexp">{{ 'RegExp Pattern' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="{{ 'RegExp string used for filtering files. It allows to select only files that match the pattern. If this string is empty, then a default pattern is used that matches images with the following extensions: jpg, jpeg, gif, png. Read manual for more information.' |trans}}"><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
		<div class="uk-form-controls">
			<input id="wk-regexp" class="uk-form-width-large" type="text" ng-model="content.data['regexp']">
		</div>
	</div>
	
	<div class="uk-form-row">
		<span class="uk-form-label" for="wk-order">{{'Order' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="{{ 'This field defines the sorting options applied to the files.' |trans}}"><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
		<div class="uk-form-controls">
			<select id="wk-order" class="uk-form-width-large" ng-model="content.data['sort_by']">
				<option value="filename_asc">{{'Alphabetical' | trans}}</option>
				<option value="filename_desc">{{'Alphabetical Reversed' | trans}}</option>
				<option value="date_desc">{{'Latest First' | trans}}</option>
				<option value="date_asc">{{'Latest Last' | trans}}</option>
				<option value="random">{{'Random' | trans}}</option>
			</select>
		</div>
	</div>

	<div class="uk-form-row">
		<span class="uk-form-label">{{'Title' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="{{ 'The title of each image is generated automatically from its file name. The options below control how the file name should be processed.' |trans}}"><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
		<div class="uk-form-controls uk-form-controls-text">
			<p class="uk-form-controls-condensed">
				<label><input type="checkbox" ng-model="content.data['strip_leading_numbers']"> {{'Remove leading numbers from title' | trans}}</label>
			</p>
			<p class="uk-form-controls-condensed">
				<label><input type="checkbox" ng-model="content.data['strip_trailing_numbers']"> {{'Remove trailing numbers from title' | trans}}</label>
			</p>
			<p class="uk-form-controls-condensed">
				<label><input type="checkbox" ng-model="content.data['replace_underscores']"> {{'Convert underscores into space' | trans}}</label>
			</p>
			<p class="uk-form-controls-condensed">
				<label><input type="checkbox" ng-model="content.data['replace_dashes']"> {{'Convert dashes into space' | trans}}</label>
			</p>
		</div>
	</div>

	<div class="uk-form-row">
		<span class="uk-form-label" for="wk-max-images">{{'Max Images' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="{{ 'This option allows to limit the number of images to load. If this option is empty, then no restriction to the number of images is applied.' |trans}}"><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
		<div class="uk-form-controls">
			<input id="wk-max-images" class="uk-form-width-large" type="text" ng-model="content.data['max_images']" placeholder="{{ 'Leave empty to load all images' | trans }}" >
		</div>
	</div>

	<h3 class="wk-form-heading">{{'About' | trans}}</h3>

	<?php printAboutInfo($app);?>

	<h3 class="wk-form-heading">{{'Newsletter' | trans}}</h3>
	
	<?php printNewsletterInfo($app);?>
</div>
