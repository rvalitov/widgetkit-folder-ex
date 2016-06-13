<?php
/*
FolderEx Content Provider plugin for Widgetkit 2.
Author: Ramil Valitov
E-mail: ramilvalitov@gmail.com
Web: http://www.valitov.me/
Git: https://github.com/rvalitov/widgetkit-folder-ex
*/

return array(

    'name' => 'content/folder_ex',

    'main' => 'YOOtheme\\Widgetkit\\Content\\Type',

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

            $folder = trim($content['folder'], '/');
			$r=trim($content['regexp']);
			if ($r)
				$pttrn=$r;
			else
				$pttrn  = '/\.('.implode('|', $extensions).')$/i';
            $dir    = dirname(dirname(dirname( $app['path'] ))); // TODO: cleaner? system agnostic?
            $sort   = explode('_', $content['sort_by'] ?: 'filename_asc');

            if (!$files = glob($dir.'/'.$folder.'/*')) {
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

                $data['title'] = basename($img);
                $data['media'] = $folder.'/'.basename($img);

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
            $app['angular']->addTemplate('folder_ex.edit', 'plugins/content/folder_ex/views/edit.php');
            $app['scripts']->add('widgetkit-folder_ex-controller', 'plugins/content/folder_ex/assets/controller.js');
			//Adding tooltip:
			$app['scripts']->add('uikit-tooltip', 'vendor/assets/uikit/js/components/tooltip.min.js', array('uikit'));
			$app['styles']->add('uikit-tooltip', 'https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.3/css/components/tooltip.min.css', array('uikit'));
			//Marked:
			$app['scripts']->add('marked', 'plugins/content/folder_ex/assets/marked.min.js', array('uikit'));
			//Updater:
			$app['scripts']->add('folder_ex.updater', 'plugins/content/folder_ex/assets/updater.js');
        }

    )

);