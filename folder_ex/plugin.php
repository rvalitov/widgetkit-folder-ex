<?php
/*
FolderEx Content Provider plugin for Widgetkit 2.
Author: Ramil Valitov
E-mail: ramilvalitov@gmail.com
Web: http://www.valitov.me/
Git: https://github.com/rvalitov/widgetkit-folder-ex
*/

require_once(__DIR__.'/views/WidgetkitExPlugin.php');
use WidgetkitEx\FolderEx\WidgetkitExPlugin;

return array(

    'name' => 'content/folder_ex',

    'main' => 'YOOtheme\\Widgetkit\\Content\\Type',
	
	'plugin_version' => 'v1.2.2',
	
	'plugin_date' => '27/06/2016',
	
	'plugin_logo' => 'https://raw.githubusercontent.com/wiki/rvalitov/widgetkit-folder-ex/images/logo.jpg',

    'config' => array(

        'name'  => 'folder_ex',
        'label' => 'FolderEx',
        'icon'  => 'assets/images/content-placeholder.svg',
        'item'  => array('title', 'content', 'media', 'link'),
        'data'  => array(
            'folder' => defined('WPINC') ? 'wp-content/uploads/' : 'images/', // J or WP?
            'sort_by' => 'filename_asc',
			'regexp' => '',
			'replace_dashes' => true,
			'replace_underscores' => true,
            'strip_leading_numbers' => false,
            'strip_trailing_numbers' => false
        )
    ),

    'items' => function($items, $content, $app) {

        $extensions = array('jpg', 'jpeg', 'gif', 'png');

        // caching
        $now       = time();
        $expires   = 5 * 60;
        $hash      = function($content) {
            $fields = array($content['folder'],
                $content['sort_by'],
				$content['regexp'],
				$content['strip_leading_numbers'],
				$content['replace_dashes'],
				$content['replace_underscores'],
                $content['strip_trailing_numbers']);
            return md5(serialize($fields));
        };

        $newitems = array();

        // cache invalid?
        if(array_key_exists('hash', $content) // never cached
            || $now - $content['hashed'] > $expires // cached values too old
            || $hash($content) != $content['hash']) { // content settings have changed

            $folder = trim($content['folder'], DIRECTORY_SEPARATOR);
			$r=trim($content['regexp']);
			if ($r)
				$pttrn=$r;
			else
				$pttrn  = '/\.('.implode('|', $extensions).')$/i';
            $dir    = dirname(dirname(dirname( $app['path'] ))); // TODO: cleaner? system agnostic?
            $sort   = explode('_', $content['sort_by'] ?: 'filename_asc');

            if (!$files = glob($dir.DIRECTORY_SEPARATOR.$folder.DIRECTORY_SEPARATOR.'*')) {
                return;
            }

            if($sort[0] == 'date') {
                usort($files, function($a, $b) {
                    return filemtime($a) > filemtime($b);
                });
            }

            if (isset($sort[1]) && $sort[1] == 'desc') {
                $files = array_reverse($files);
            }

            foreach ($files as $img) {

                // extension filter
                if (!@preg_match($pttrn, $img)) {
                    continue;
                }

                $data = array();

                $data['title'] = WidgetkitExPlugin::mb_basename($img);
                $data['media'] = implode(DIRECTORY_SEPARATOR, array_map("rawurlencode", explode(DIRECTORY_SEPARATOR, $folder.DIRECTORY_SEPARATOR.WidgetkitExPlugin::mb_basename($img))));

                // remove extension
                $data['title'] = preg_replace('/\.[^.]+$/', '', $data['title']);

                // remove leading number
                if($content['strip_leading_numbers']) {
                    $data['title'] = preg_replace('/^\d+\s?+/', '', $data['title']);
                }

                // remove trailing numbers
                if($content['strip_trailing_numbers']) {
                    $data['title'] = preg_replace('/\s?+\d+$/', '', $data['title']);
                }

				// replace underscores with space
				if($content['replace_underscores']) {
					$data['title'] = trim(str_replace('_', ' ', $data['title']));
				}
				
				// replace dashes with space
				if($content['replace_dashes']) {
					$data['title'] = trim(str_replace('-', ' ', $data['title']));
				}

                $newitems[] = $data;
            }

            // write cache
            $content['prepared'] = json_encode($newitems);
            $content['hash']     = $hash($content);
            $content['hashed']   = $now;
            $app['content']->save($content->toArray());

        } else {

            // cache is valid
            $newitems = json_decode($content['prepared'], true);

        }

        if($content['sort_by'] == "random") {
            shuffle($newitems);
        }

        if(is_numeric($content['max_images'])){
            $newitems = array_slice($newitems, 0, $content['max_images']);
        }

        foreach ($newitems as $data) {
            $items->add($data);
        }

    },

    'events' => array(

        'init.admin' => function($event, $app) {
			//Adding our own translation files
			$app['translator']->addResource('plugins/content/folder_ex/languages/'.$app['locale'].'.json');
            $app['angular']->addTemplate('folder_ex.edit', 'plugins/content/folder_ex/views/edit.php');
            $app['scripts']->add('folder_ex-controller', 'plugins/content/folder_ex/assets/controller.js');
			//Adding tooltip:
			$app['scripts']->add('uikit-tooltip', 'vendor/assets/uikit/js/components/tooltip.min.js', array('uikit'));
			$app['styles']->add('uikit-tooltip', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/components/tooltip.min.css', array('uikit'));
			//jQuery wait plugin:
			$app['scripts']->add('jquery.wait', 'plugins/content/folder_ex/assets/jquery.wait.min.js', array('uikit'));
			//Marked:
			$app['scripts']->add('marked', 'plugins/content/folder_ex/assets/marked.min.js', array('uikit'));
			//Mailchimp for subscription:
			$app['scripts']->add('mailchimp', 'plugins/content/folder_ex/assets/jquery.formchimp.min.js', array('uikit'));
			//jQuery form validator http://www.formvalidator.net/:
			$app['scripts']->add('jquery-form-validator', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.20/jquery.form-validator.min.js', array('uikit'));
			//Underscore.js
			$app['scripts']->add('underscore', 'plugins/content/folder_ex/assets/underscore-min.js', array('uikit'));
			//Semantic version compare
			$app['scripts']->add('versioncompare', 'plugins/content/folder_ex/assets/versioncompare.js', array('uikit'));
			//Generating dynamic update script:
			$plugin=new WidgetkitExPlugin($app);
			$app['scripts']->add('folder_ex.dynamic-updater', $plugin->generateUpdaterJS($app), array(), 'string');
        }

    )

);
