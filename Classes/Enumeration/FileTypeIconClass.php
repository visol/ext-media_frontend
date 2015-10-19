<?php
namespace Visol\MediaFrontend\Enumeration;

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

/**
 * Enumeration for languages.
 */
class FileTypeIconClass {

	public static $extensionToIconClass = array(
		'png' => 'image',
		'jpg' => 'image',
		'jpeg' => 'image',
		'tiff' => 'image',
		'tif' => 'image',
		'eps' => 'image',
		'svg' => 'image',
		'gif' => 'image',
		'doc' => 'word',
		'docx' => 'word',
		'dot' => 'word',
		'dotx' => 'word',
		'rtf' => 'word',
		'xls' => 'excel',
		'xlsx' => 'excel',
		'csv' => 'excel',
		'ppt' => 'powerpoint',
		'pptx' => 'powerpoint',
		'pps' => 'powerpoint',
		'ppsx' => 'powerpoint',
		'pdf' => 'pdf',
		'mp4' => 'video',
		'mov' => 'video',
		'wmv' => 'video',
		'm4a' => 'audio',
		'mp3' => 'audio',
		'wma' => 'audio'
	);

}
