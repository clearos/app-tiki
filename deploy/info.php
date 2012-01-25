<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'tiki_wiki';
$app['version'] = '6.2.0.beta3';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('tiki_wiki_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('tiki_wiki_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_messaging_and_collaboration');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-network', 
    'app-groups',
    'app-users',
    'app-mysql',
);

$app['core_requires'] = array(
    'app-groups-core',
    'app-users-core',
    'app-mysql-core',
    'tiki',
);

$app['core_directory_manifest'] = array(
    '/var/clearos/tiki_wiki' => array(),
    '/var/clearos/tiki_wiki/backup/' => array(),
);
