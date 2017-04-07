<?php

class SGFTPStorage
{
	private $connectionId = null;
	private $host;
	private $port;
	private $user;
	private $password;
	private $activeDirectory;
	private $delegate;
	private $state;
	private $offset = 0;
	const BUFFER_SIZE = 4194304; // 4mb

	public function __construct()
	{
		$this->host = SGConfig::get('SG_FTP_HOST');
		$this->port = SGConfig::get('SG_FTP_PORT');
		$this->user = SGConfig::get('SG_FTP_USER');
		$this->password = SGConfig::get('SG_FTP_PASSWORD');
		$this->activeDirectory = SGConfig::get('SG_FTP_ROOT_FOLDER');
	}

	public function setDelegate($delegate)
	{
		$this->delegate = $delegate;
	}

	public function setStateData($state)
	{
		$this->state = $state;
	}

	public function connect()
	{
		$connId = @ftp_connect($this->host, $this->port);
		if (!$connId) {
			throw new SGExceptionForbidden('Could not connect to the FTP server: '.$this->host);
		}

		$login = @ftp_login($connId, $this->user, $this->password);
		if (!$login) {
			throw new SGExceptionForbidden('Could not connect to the FTP server: '.$this->host);
		}

		SGConfig::set('SG_FTP_CONNECTION_STRING', $this->user.'@'.$this->host.':'.$this->port);
		$this->connectionId = $connId;
	}

	public function getListOfFiles($rootPath)
	{
		return ftp_nlist($this->connectionId, $rootPath);
	}

	public function getFileSize($path)
	{
		return ftp_size($this->connectionId, $path);
	}

	public function getCreateDate($path)
	{
		return ftp_mdtm($this->connectionId, $path);
	}

	public function changeDirectory($directory)
	{
		return ftp_chdir($this->connectionId, $directory);
	}

	public function createFolder($path)
	{
		return @ftp_mkdir($this->connectionId, $path);
	}

	public function downloadFile($file, $size)
	{
		$loaclFilePath = SG_BACKUP_DIRECTORY.basename($file);
		$serverFilePath = $file;

		$result = ftp_nb_get($this->connectionId, $loaclFilePath, $serverFilePath, FTP_BINARY);

		while ($result == FTP_MOREDATA) {
			if (!file_exists($loaclFilePath)) {
				break;
			}
			$result = ftp_nb_continue($this->connectionId);
		}

		return $result == FTP_FINISHED?true:false;
	}

	private function saveStateData($uploadId, $offset)
	{
		$this->delegate->saveStateData($uploadId, $offset);
	}

	public function uploadFile($filePath)
	{
		$rootPath = rtrim($this->activeDirectory, '/').'/'.SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME');
		$path = rtrim($rootPath, '/').'/'.basename($filePath);

		$fileSize = realFilesize($filePath);

		$this->delegate->willStartUpload();

		$fp = @fopen($filePath, 'rb');

		ftp_set_option($this->connectionId, FTP_AUTOSEEK, TRUE);

		$ret = ftp_nb_fput($this->connectionId, $path, $fp, FTP_BINARY, FTP_AUTORESUME);
		SGPing::update();

		//get how many bytes were uploaded
		$this->offset = $this->state->getOffset();
		while ($ret == FTP_MOREDATA) {
			$ret = ftp_nb_continue($this->connectionId);

			$progress = ftell($fp)*100.0/$fileSize;
			$this->delegate->updateProgressManually($progress);
			SGPing::update();

			$shouldReload = $this->shouldReload(ftell($fp));
			$this->saveStateData(null, $this->offset);
			if (backupGuardIsReloadingPossible() && $shouldReload) {
				@fclose($fp);
				$this->reload();
			}
		}

		@fclose($fp);

		if ($ret != FTP_FINISHED) {
			throw new SGExceptionServerError('The file was not uploaded correctly.');
		}
	}

	public function shouldReload($offset)
	{
		if(($offset - $this->offset) >= self::BUFFER_SIZE) {
			$this->offset = $offset;
			return true;
		}

		return false;
	}

	public function reload()
	{
		$this->delegate->reload();
	}

	public function deleteFile($fileName)
	{
		return @ftp_delete($this->connectionId, $fileName);
	}

	public function deleteFolder($folderName)
	{
		return $this->deleteFolderWithFiles($folderName);
	}

	private function deleteFolderWithFiles($directory)
	{
		if (empty($directory)) {
			return false;
		}

		if (!(@ftp_rmdir($this->connectionId, $directory) || @ftp_delete($this->connectionId, $directory))) {
			//if the attempt to delete fails, get the file listing
			$fileList = @ftp_nlist($this->connectionId, $directory);

			//loop through the file list and recursively delete the file in the list
			foreach ($fileList as $file) {
				if ($file=='.' || $file=='..') {
					continue;
				}

				$this->deleteFolderWithFiles($directory.'/'.$file);
			}

			//if the file list is empty, delete the directory we passed
			$this->deleteFolderWithFiles($directory);
		}

		return true;
	}
}
