<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Visol.' . $_EXTKEY,
	'Mediafrontend',
	array(
		'MediaFrontend' => 'folderTreeView,fileBrowserView',
		'MediaFrontendApi' => 'treeViewData,fileBrowserData',
	),
	// non-cacheable actions
	array(
		'MediaFrontend' => 'folderTreeView,fileBrowserView',
		'MediaFrontendApi' => 'treeViewData,fileBrowserData',
	)
);

// Register global route
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['routing']['globalRoutes'][] = 'EXT:media_frontend/Configuration/GlobalRoutes.yaml';
