jQuery(document).ready(function($){
	/* General settings */
	var git_url='https://github.com/rvalitov/';
	var api_url='https://api.github.com/repos/rvalitov/';
	var infotimeout=5000;
	
	/* Start of widget specific settings */
	var distr_name='widgetkit-folder-ex';
	var widget_name='FolderEx';
	var widget_version='v1.0.0';
	/*CAUTION: the month is zero-based*/
	var widget_date=printNiceDate(new Date(2016,05,13));
	var widget_logo='https://raw.githubusercontent.com/wiki/rvalitov/widgetkit-folder-ex/images/logo.jpg';
	var widget_wiki=git_url+distr_name+'/wiki';
	var widget_website=git_url+distr_name;
	/* End of widget specific settings */
	
	var widget_update_tag='#update-'+distr_name;
	
	(function ($) {
		/**
		* @function
		* @property {object} jQuery plugin which runs handler function once specified element is inserted into the DOM
		* @param {function} handler A function to execute at the time when the element is inserted
		* @param {bool} shouldRunHandlerOnce Optional: if true, handler is unbound after its first invocation
		* @example $(selector).waitUntilExists(function);
		*/

		$.fn.waitUntilExists    = function (handler, shouldRunHandlerOnce, isChild) {
			var found       = 'found';
			var $this       = $(this.selector);
			var $elements   = $this.not(function () { return $(this).data(found); }).each(handler).data(found, true);

			if (!isChild)
			{
				(window.waitUntilExists_Intervals = window.waitUntilExists_Intervals || {})[this.selector] =
					window.setInterval(function () { $this.waitUntilExists(handler, shouldRunHandlerOnce, true); }, 500);
			}
			else if (shouldRunHandlerOnce && $elements.length)
			{
				window.clearInterval(window.waitUntilExists_Intervals[this.selector]);
			}

			return $this;
		};
	}(jQuery));
	
	/* Filing the about info */
	$('#name-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append(widget_name);
	});
	$('#build-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append(widget_date);
	});
	$('#website-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append('<a href="'+widget_website+'" target="_blank">'+widget_website+'<i class="uk-icon uk-icon-external-link uk-margin-small-left"></i></a>');
	});
	$('#version-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append(widget_version);
	});
	$('#logo-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append('<img class="uk-width-1-1" src="'+widget_logo+'" style="max-width:300px;">');
	});
	$('#wiki-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append('<a href="'+widget_wiki+'" target="_blank">'+widget_wiki+'<i class="uk-icon uk-icon-external-link uk-margin-small-left"></i></a>');
	});
	$('#version-jquery-'+distr_name).waitUntilExists(function(){
		$(this).empty();
		$(this).append($.fn.jquery);
	});
	$('#version-uikit-'+distr_name).waitUntilExists(function(){
		if (UIkit && UIkit.version){
			$(this).empty();
			$(this).append(UIkit.version);
		}
	});
	$('#version-angularjs-'+distr_name).waitUntilExists(function(){
		if (angular && angular.version && angular.version.full){
			$(this).empty();
			$(this).append(angular.version.full);
		}
	});
	
	function isNewVersionAvailable(vCurrent,vRemote){
		if (typeof vCurrent + typeof vRemote != 'stringstring')
			return false;
    
		left=vCurrent.replace(/^\D/,'');
		right=vRemote.replace(/^\D/,'');
		var a = left.split('.')
		,   b = right.split('.')
		,   i = 0, len = Math.max(a.length, b.length);
			
		for (; i < len; i++) {
			if ((a[i] && !b[i] && parseInt(a[i]) > 0) || (parseInt(a[i]) > parseInt(b[i]))) {
				return false;
			} else if ((b[i] && !a[i] && parseInt(b[i]) > 0) || (parseInt(a[i]) < parseInt(b[i]))) {
				return true;
			}
		}
		return false;
	}

	function printNiceDate(MyDate,dateSeparator){
		if (typeof dateSeparator!='string'){
			dateSeparator='/';
		}
		return ('0' + MyDate.getDate()).slice(-2) + dateSeparator + ('0' + (MyDate.getMonth()+1)).slice(-2) + dateSeparator + MyDate.getFullYear();
	}
	function failedToUpdate(){
		$(widget_update_tag).waitUntilExists(function(){
			$('div.update-info-'+distr_name).addClass('uk-hidden');
			$('#update-problem-'+distr_name).removeClass('uk-hidden');
		});
	}
	
	$.ajax({
			'url': api_url+distr_name+'/releases/latest',
			'type' : "GET",
			'dataType' : 'json',
			success: function (data, textStatus, jqXHR){
				if (data){
					if (isNewVersionAvailable(widget_version,data.tag_name)){
						var date_remote = Date.parse(data.published_at);
						if (date_remote>0){
							date_remote=printNiceDate(new Date(date_remote));
						}
						else {
							date_remote='';
						}
						var infotext='<p class="uk-margin-remove"><i class="uk-icon-info-circle uk-margin-small-right"></i>New version of plugin '+widget_name+' '+data.tag_name+' is available!</p><p class="uk-text-center uk-margin-remove"><a href="'+data.html_url+'" target="_blank" class="uk-button uk-button-mini uk-button-success"><i class="uk-icon-external-link uk-margin-small-right"></i>Upgrade</a></p>';
						/*We only show update notifications on the Widgetkit page*/
						if ( (window.location.href.indexOf('com_widgetkit')>0) || (window.location.href.indexOf('page=widgetkit')>0) )
							UIkit.notify(infotext, {'timeout':infotimeout,'pos':'top-center','status':'warning'});
						$(widget_update_tag).waitUntilExists(function(){
							$('div.update-info-'+distr_name).addClass('uk-hidden');
							$('#update-available-'+distr_name).removeClass('uk-hidden');
							
							$('#version-local-'+distr_name).empty();
							$('#version-local-'+distr_name).append(widget_version);
							
							$('#version-remote-'+distr_name).empty();
							$('#version-remote-'+distr_name).append(data.tag_name);
							
							$('#date-local-'+distr_name).empty();
							$('#date-local-'+distr_name).append(widget_date);
							
							$('#date-remote-'+distr_name).empty();
							if (date_remote.length)
								$('#date-remote-'+distr_name).append(date_remote);
							
							$('#release-info-'+distr_name).empty();
							$('#release-info-'+distr_name).append(marked(data.body));
							
							$('#update-logo-'+distr_name).attr('src',widget_logo);
							
							$('#download-'+distr_name).attr('href',data.html_url);
							
							$('#instructions-'+distr_name).attr('href',widget_wiki);
						});
					}
					else{
						$(widget_update_tag).waitUntilExists(function(){
							$('div.update-info-'+distr_name).addClass('uk-hidden');
							$('#update-ok-'+distr_name).removeClass('uk-hidden');
						});
					}
				}
				else{
					failedToUpdate();
				}
			},
			error: function (jqXHR, textStatus, errorThrown ){
				failedToUpdate();
			}
		});
});