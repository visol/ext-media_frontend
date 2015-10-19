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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * LinkController
 */
class MediaFrontendController extends AbstractController {

	/**
	 * Displays a tree of all available folders for the current user
	 */
	public function folderTreeViewAction() {
		$this->view->assign('contentObjectData', $this->getContentObjectData());
	}

	public function fileBrowserViewAction() {
	}

}