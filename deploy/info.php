<?php

/////////////////////////////////////////////////////////////////////////////
// General information
/////////////////////////////////////////////////////////////////////////////

$app['basename'] = 'tiki';
$app['version'] = '2.0.14';
$app['release'] = '1';
$app['vendor'] = 'ClearFoundation';
$app['packager'] = 'ClearFoundation';
$app['license'] = 'GPLv3';
$app['license_core'] = 'LGPLv3';
$app['description'] = lang('tiki_app_description');

/////////////////////////////////////////////////////////////////////////////
// App name and categories
/////////////////////////////////////////////////////////////////////////////

$app['name'] = lang('tiki_app_name');
$app['category'] = lang('base_category_server');
$app['subcategory'] = lang('base_subcategory_content_management_systems');

/////////////////////////////////////////////////////////////////////////////
// Controllers
/////////////////////////////////////////////////////////////////////////////

$app['controllers']['tiki']['title'] = $app['name'];
$app['controllers']['settings']['title'] = lang('base_settings');
$app['controllers']['upload']['title'] = lang('base_app_upload');
$app['controllers']['advanced']['title'] = lang('base_app_advanced_settings');

/////////////////////////////////////////////////////////////////////////////
// Packaging
/////////////////////////////////////////////////////////////////////////////

$app['requires'] = array(
    'app-webapp',
    'app-system-database >= 1:1.6.1',
);

$app['core_requires'] = array(
    'app-webapp-core',
    'app-system-database-core >= 1:1.6.1',
    'webapp-tiki',
);

$app['core_directory_manifest'] = array(
    '/var/clearos/tiki' => array(),
    '/var/clearos/tiki/archive' => array(),
    '/var/clearos/tiki/backup' => array(),
);

$app['core_file_manifest'] = array(
    'webapp-tiki-flexshare.conf' => array(
        'target' => '/etc/clearos/flexshare.d/webapp-tiki.conf',
        'config' => TRUE,
        'config_params' => 'noreplace'
    ),
    'webapp-tiki-httpd.conf' => array(
        'target' => '/etc/httpd/conf.d/webapp-tiki.conf',
        'config' => TRUE,
        'config_params' => 'noreplace'
    )
);
