<?php
require_once(SG_STORAGE_PATH.'SGStorage.php');
require_once(SG_STORAGE_PATH.'SGFTPStorage.php');
require_once(SG_STORAGE_PATH.'SGSFTPStorage.php');

class SGFTPManager extends SGStorage
{
	private $method;
	private $proxy;

	public function init()
	{
		$this->method = SGConfig::get('SG_STORAGE_CONNECTION_METHOD');
		if ($this->method == 'ftp') {
			//check if ftp extension is loaded
			SGBoot::checkRequirement('ftp');
		}

		$this->setActiveDirectory(SGConfig::get('SG_FTP_ROOT_FOLDER'));
	}

	public function connect()
	{
		if ($this->isConnected()) {
			return;
		}

		if ($this->method == 'ftp') {
			$this->proxy = new SGFTPStorage();
		}
		else {
			$this->proxy = new SGSFTPStorage();

		}

		$this->proxy->setDelegate($this);
		$this->proxy->setStateData($this->state);
		$this->proxy->connect();

		$this->connected = true;
	}

	public function connectOffline()
	{
		$this->connect();
	}

	public function checkConnected()
	{
		$this->connected = $this->isConnected()?true:false;
	}

	public function getListOfFiles()
	{
		$this->connect();
		if (!$this->isConnected()) {
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		$this->rootPath = rtrim($this->getActiveDirectory(), '/').'/'.rtrim(SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME'), '/');
		$files = $this->proxy->getListOfFiles($this->rootPath);

		$listOfFiles = array();
		foreach ($files as $file) {
			if ($file == '.' || $file == '..') {
				continue;
			}

			$path = rtrim($this->rootPath, '/').'/'.$file;
			$size = $this->proxy->getFileSize($path);
			$createDate = $this->proxy->getCreateDate($path);

			$listOfFiles[$file] = array(
				'name' => $file,
				'size' => $size,
				'date' => date('Y-m-d H:i:s', $createDate),
				'path' => $path,
			);
		}

		krsort($listOfFiles);
		return $listOfFiles;
	}

	public function setActiveDirectory($directory)
	{
		parent::setActiveDirectory($directory);
		if ($this->isConnected()) {
			if (!@$this->proxy->changeDirectory($directory))
			{
				throw new SGExceptionForbidden('Could not change directory');
			}
		}
	}

	public function createFolder($folderName)
	{
		if (!$this->isConnected()) {
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		$folders = explode('/', $folderName);

		for ($i=0; $i < count($folders); $i++) {
			$path = rtrim($this->getActiveDirectory(), '/').'/'.$folders[$i];
			$this->proxy->createFolder($path);
			$this->setActiveDirectory($path);
		}

		return $path;
	}

	public function downloadFile($file, $size)
	{
		$this->connect();
		if (!$this->isConnected()) {
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		return $this->proxy->downloadFile($file, $size);
	}

	public function saveStateData($uploadId, $offset)
	{
		$token = $this->delegate->getToken();
		$actionId = $this->delegate->getActionId();
		$queuedStorageUploads = $this->delegate->getQueuedStorageUploads();
		$currentUploadChunksCount = 0;

		$this->state->setCurrentUploadChunksCount($currentUploadChunksCount);
		$this->state->setStorageType(SG_STORAGE_FTP);
		$this->state->setQueuedStorageUploads($queuedStorageUploads);
		$this->state->setToken($token);
		$this->state->setUploadId($uploadId);
		$this->state->setOffset($offset);
		$this->state->setAction(SG_STATE_ACTION_UPLOADING_BACKUP);
		$this->state->setActiveDirectory($this->getActiveDirectory());
		$this->state->setActionId($actionId);
		$this->state->save();
	}

	public function uploadFile($filePath)
	{
		$this->connect();
		if (!$this->isConnected()) {
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		if (!file_exists($filePath) || !is_readable($filePath)) {
			throw new SGExceptionNotFound('File does not exist or is not readable: '.$filePath);
		}

		$this->proxy->uploadFile($filePath);
	}

	public function willStartUpload()
	{
		$this->delegate->willStartUpload(1);
	}

	public function updateProgressManually($progress)
	{
		$this->delegate->updateProgressManually($progress);
	}

	public function deleteFile($fileName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		return $this->proxy->deleteFile($fileName);
	}

	public function deleteFolder($folderName)
	{
		if (!$this->isConnected())
		{
			throw new SGExceptionForbidden('Permission denied. Authentication required.');
		}

		return $this->proxy->deleteFolder($folderName);
	}
}
