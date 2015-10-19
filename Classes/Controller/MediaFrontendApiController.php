<?php
namespace Visol\MediaFrontend\Controller;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Visol\MediaFrontend\Enumeration\FileTypeIconClass;

/**
 * Question Controller
 */
class MediaFrontendApiController extends AbstractController {

	/**
	 * @var string
	 */
	protected $defaultViewObjectName = 'TYPO3\CMS\Extbase\Mvc\View\JsonView';

	/**
	 * @param integer $configurationContentUid
	 * @return string
	 */
	public function treeViewDataAction($configurationContentUid) {
		$baseFolder = $this->getBaseFolderForConfiguration($configurationContentUid);
		$apiData = $this->getApiDataForFolder($baseFolder);
		$apiData = $apiData['children'];
		$this->response->setHeader('Content-Type', 'application/json');
		return json_encode($apiData);
	}

	/**
	 * Create an array with data from a folder
	 *
	 * @param \TYPO3\CMS\Core\Resource\Folder $folder
	 * @return array
	 */
	protected function getApiDataForFolder(\TYPO3\CMS\Core\Resource\Folder $folder) {
		// Permission check
		$userFeGroups = !isset($GLOBALS['TSFE']->fe_user->user) ? FALSE : $GLOBALS['TSFE']->fe_user->groupData['uid'];
		if (!$this->getCheckPermissionsService()->checkFolderRootLineAccess($folder, $userFeGroups)) {
			return FALSE;
		}

		$folderData = array();
		if (!empty($folder->getSubfolders())) {
			$folderData['title'] = $folder->getName();
			$folderData['folder'] = TRUE;
			$folderData['key'] = base64_encode($folder->getCombinedIdentifier());
			$folderData['children'] = array();
			foreach ($folder->getSubfolders() as $folder) {
				/** @var \TYPO3\CMS\Core\Resource\Folder $folder */
				$apiDataForFolder = $this->getApiDataForFolder($folder);
				if ($apiDataForFolder) {
					$folderData['children'][] = $apiDataForFolder;
				}
			}
			return $folderData;
		} else {
			$folderData = array(
				'title' => $folder->getName(),
				'folder' => TRUE,
				'key' => base64_encode($folder->getCombinedIdentifier()));
		}
		return $folderData;
	}

	/**
	 * @param string $folderCombinedIdentifier
	 * @return string
	 */
	public function fileBrowserDataAction($folderCombinedIdentifier = '') {
		// TODO check permission for storage:path
		if (!empty($folderCombinedIdentifier)) {
			$folderCombinedIdentifier = base64_decode($folderCombinedIdentifier);
			$folder = $this->getResourceFactory()->getFolderObjectFromCombinedIdentifier($folderCombinedIdentifier);
			$files = $folder->getFiles();
			$data = array();
			foreach ($files as $file) {
				/** @var \TYPO3\CMS\Core\Resource\File $file */
				$fileData = array();
				$fileData['name'] = $file->getNameWithoutExtension();
				$fileData['extension'] = $file->getExtension();
				$fileData['publicUrl'] = $file->getPublicUrl();
				$fileData['modificationTime'] = strftime('%d.%m.%y', $file->getModificationTime());
				$fileData['fileTypeIconClass'] = array_key_exists($file->getExtension(), FileTypeIconClass::$extensionToIconClass) ? 'icon-file-' . FileTypeIconClass::$extensionToIconClass[$file->getExtension()] : 'icon-doc';
				$data[] = $fileData;
			}
			$this->response->setHeader('Content-Type', 'application/json');
			return json_encode(array('data' => $data));
		} else {
			$emptyData = array('data' => array());
			return json_encode($emptyData);
		}
	}

	/**
	 * @param integer $configurationContentUid
	 * @return null|\TYPO3\CMS\Core\Resource\Folder
	 */
	protected function getBaseFolderForConfiguration($configurationContentUid) {
		$configurationContent = $this->getDatabaseConnection()->exec_SELECTgetSingleRow('*', 'tt_content', 'NOT deleted AND NOT hidden AND uid=' . $configurationContentUid);
		if (!empty($configurationContent)) {
			$flexformData = GeneralUtility::xml2array($configurationContent['pi_flexform']);
			if (is_array($flexformData)) {
				if (isset($flexformData['data']['sDEF']['lDEF']['settings.storageUid']['vDEF'])) {
					$storageUid = (int)$flexformData['data']['sDEF']['lDEF']['settings.storageUid']['vDEF'];
				}
				if (isset($flexformData['data']['sDEF']['lDEF']['settings.folder']['vDEF'])) {
					$folder = $flexformData['data']['sDEF']['lDEF']['settings.folder']['vDEF'];
				}
			}
		}
		if ($storageUid && $folder) {
			return $this->getResourceFactory()->getFolderObjectFromCombinedIdentifier($storageUid . ':' . $folder);
		} else {
			return NULL;
		}
	}

	/**
	 * @return \BeechIt\FalSecuredownload\Security\CheckPermissions
	 */
	protected function getCheckPermissionsService() {
		return GeneralUtility::makeInstance('BeechIt\\FalSecuredownload\\Security\\CheckPermissions');
	}

}