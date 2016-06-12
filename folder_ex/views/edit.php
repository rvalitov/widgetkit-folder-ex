<?php
/*
FolderEx Content Provider plugin for Widgetkit 2.
Author: Ramil Valitov
E-mail: ramilvalitov@gmail.com
Web: http://www.valitov.me/
Git: https://github.com/rvalitov/widgetkit-folder-ex
*/
?>

<div class="uk-grid uk-grid-divider uk-form uk-form-horizontal" ng-controller="folderCtrl as folder" data-uk-grid-margin>
    <div class="uk-width-medium-1-4">

        <div class="wk-panel-marginless">
            <ul class="uk-nav uk-nav-side" data-uk-switcher="{connect:'#nav-content-folder'}">
                <li><a href="#">{{'Content' | trans}}</a></li>
				<li><a href="#">{{'About' | trans}}</a></li>
            </ul>
        </div>

    </div>
    <div class="uk-width-medium-3-4">

        <ul id="nav-content-folder" class="uk-switcher">
            <li>
				<h3 class="wk-form-heading">{{'Content' | trans}}</h3>
				<div class="uk-panel uk-panel-box uk-alert">
					<p><i class="uk-icon uk-icon-info-circle uk-margin-small-right"></i>{{ 'This Content Source allows you to select image files from a specified folder using sorting and filtering options. These files will be used as content items for the widget you selected.' | trans}}</p>
				</div>

				<div class="uk-form-row">
					<span class="uk-form-label" for="wk-path">{{ 'Folder Path' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="The folder where the images are stored. This field is mandatory."><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
					<div class="uk-form-controls">
						<input id="wk-path" class="uk-form-width-large" type="text" ng-model="content.data['folder']">
					</div>
				</div>

				<div class="uk-form-row">
					<span class="uk-form-label" for="wk-regexp">{{ 'RegExp Pattern' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="RegExp string used for filtering files. It allows to select only files that match the pattern. If this string is empty, then a default pattern is used that matches images with the following extensions: jpg, jpeg, gif, png. Read manual for more information."><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
					<div class="uk-form-controls">
						<input id="wk-regexp" class="uk-form-width-large" type="text" ng-model="content.data['regexp']">
					</div>
				</div>
				
				<div class="uk-form-row">
					<span class="uk-form-label" for="wk-order">{{'Order' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="This field defines the sorting options applied to the files."><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
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
					<span class="uk-form-label">{{'Title' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="The title of each file is generated automatically from the file name. The options below control how the file name should be processed and altered."><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
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
					<span class="uk-form-label" for="wk-max-images">{{'Max Images' | trans}}<span  data-uk-tooltip style="margin-top: 5px;" title="This option allows to limit the number of images to select. If this option is empty, then no restriction to the number of images is applied."><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span></span>
					<div class="uk-form-controls">
						<input id="wk-max-images" class="uk-form-width-large" type="text" ng-model="content.data['max_images']" placeholder="{{ 'Leave empty to load all images' | trans }}" >
					</div>
				</div>
			</li>
			<li>
				<h3 class="wk-form-heading">{{'About' | trans}}</h3>
	
				<div class="uk-grid">
					<div class="uk-text-center uk-width-medium-1-3" id="logo-widgetkit-folder-ex">
					</div>
					<div class="uk-width-medium-2-3">
						<table class="uk-table uk-table-striped">
							<tr>
								<td>
									Plugin Name
								</td>
								<td id="name-widgetkit-folder-ex">
									N/A
								</td>
							</tr>
							<tr>
								<td>
									Plugin Version
								</td>
								<td id="version-widgetkit-folder-ex">
									N/A
								</td>
							</tr>
							<tr>
								<td>
									Plugin Build Date
								</td>
								<td id="build-widgetkit-folder-ex">
									N/A
								</td>
							</tr>
							<tr>
								<td>
									Widgetkit Version
								</td>
								<td id="version-wk-widgetkit-folder-ex">
									<?php echo (isset($app['version']))?$app['version']:'Unknown';?>
								</td>
							</tr>
							<tr>
								<td>
									Database Version
								</td>
								<td id="version-db-widgetkit-folder-ex">
									<?php echo (isset($app['db_version']))?$app['db_version']:'Unknown';?>
								</td>
							</tr>
							<tr>
								<td>
									jQuery Version
								</td>
								<td id="version-jquery-widgetkit-folder-ex">
									Unknown
								</td>
							</tr>
							<tr>
								<td>
									AngularJS Version
								</td>
								<td id="version-angularjs-widgetkit-folder-ex">
									Unknown
								</td>
							</tr>
							<tr>
								<td>
									Author<span data-uk-tooltip title="See the complete information about contributors and acknowledgement on the website below."><i class="uk-icon uk-icon-question-circle uk-margin-small-left" style="color:#ffb105"></i></span>
								</td>
								<td>
									<a href="https://valitov.me" target="_blank">Ramil Valitov<i class="uk-icon uk-icon-external-link uk-margin-small-left"></i></a>
								</td>
							</tr>
							<tr>
								<td>
									Website
								</td>
								<td id="website-widgetkit-folder-ex">
									N/A
								</td>
							</tr>
							<tr>
								<td>
									Wiki and Manuals
								</td>
								<td id="wiki-widgetkit-folder-ex">
									N/A
								</td>
							</tr>
						</table>
						<div id="update-widgetkit-folder-ex" class="uk-text-center">
						</div>
					</div>
				<div>
			</li>
		</ul>
	</div>
</div>
