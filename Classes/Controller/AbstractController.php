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
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {
	
	/**
	 * @return \TYPO3\CMS\Core\Resource\ResourceFactory
	 */
	public function getResourceFactory() {
		return \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
	}


	/**
	 * @return \TYPO3\CMS\Core\Database\DatabaseConnection
	 */
	public function getDatabaseConnection() {
		return $GLOBALS['TYPO3_DB'];
	}

	/**
	 * @return \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
	 */
	public function getContentObjectData() {
		return $this->configurationManager->getContentObject()->data;
	}

}