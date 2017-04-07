<?php
set_include_path(SG_LIB_PATH . 'phpseclib');
include('Net/SFTP.php');
include('Crypt/RSA.php');

class SGSFTPStorage
{
	private $sftp = null;
	private $method;
	private $host;
	private $port;
	private $user;
	private $password;
	private $keyFilePath;
	private $activeDirectory;
	private $delegate;
	private $state;

	public function __construct()
	{
		$this->keyFilePath = SGConfig::get('SG_SFTP_KEY_FILE_PATH');
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
		$this->sftp = new Net_SFTP($this->host, $this->port);

		if(!empty($this->keyFilePath)) {
			$key = new Crypt_RSA();
			$key->setPassword($this->password);
			$key->loadKey(file_get_contents($this->keyFilePath));
			$login = $this->sftp->login($this->user, $key);
		}
		else {
			$login = $this->sftp->login($this->user, $this->password);
		}

		if (!$login) {
			throw new SGExceptionForbidden('Could not connect to the SFTP server: '.$this->host);
		}

		SGConfig::set('SG_FTP_CONNECTION_STRING', $this->user.'@'.$this->host.':'.$this->port);
	}

	public function getFileInfo($path)
	{
		return $this->sftp->stat($path);
	}

	public function getFileSize($path)
	{
		$pathInfo = $this->getFileInfo($path);
		return $pathInfo['size'];
	}

	public function getCreateDate($path)
	{
		$pathInfo = $this->getFileInfo($path);
		return $pathInfo['mtime'];
	}

	public function getListOfFiles($rootPath)
	{
		return $this->sftp->nlist($rootPath);
	}

	public function changeDirectory($directory)
	{
		return $this->sftp->chdir($directory);
	}

	public function createFolder($folderPath)
	{
		return $this->sftp->mkdir($folderPath);
	}

	public function downloadFile($file, $size)
	{
		$offset = 0;
		$result = false;
		$chunk = 4*1024*1024; // 4MB
		$loaclFilePath = SG_BACKUP_DIRECTORY.basename($file);
		$serverFilePath = $file;

		$fp = @fopen($loaclFilePath, 'ab');

		while ($size > $offset) {
			if (!file_exists($loaclFilePath)) {
				$result = false;
				break;
			}

			$data = $this->sftp->get($serverFilePath, false, $offset, $chunk);

			if (strlen($data)) {
				fwrite($fp, $data);
			}
			else {
				break;
			}

			$offset += $chunk;
			$result = true;
		}

		return $result;
	}

	private function saveStateData($uploadId, $offset)
	{
		$this->delegate->saveStateData($uploadId, $offset);
	}

	public function uploadFile($filePath)
	{
		$chunk = 4 * 1024 * 1024; // 4 MB
		$rootPath = rtrim($this->activeDirectory, '/').'/'.SGConfig::get('SG_STORAGE_BACKUPS_FOLDER_NAME');
		$path = rtrim($rootPath, '/').'/'.basename($filePath);

		$fileSize = realFilesize($filePath);

		$this->delegate->willStartUpload();

		$fp = @fopen($filePath, 'rb');
		SGPing::update();

		$offset = $this->state->getOffset();
		fseek($fp, $offset);
		while ($offset < $fileSize) {
			$data = fread($fp, $chunk);
		    $this->sftp->put($path, $data, NET_SFTP_RESUME);

		    $offset = ftell($fp);
			$progress = $offset*100.0/$fileSize;
			$this->delegate->updateProgressManually($progress);
			SGPing::update();

			$this->saveStateData(null, $offset);
			if (backupGuardIsReloadingPossible()) {
				@fclose($fp);
				$this->reload();
			}
		}

		@fclose($fp);
	}

	public function reload()
	{
		$this->delegate->reload();
	}

	public function deleteFile($fileName)
	{
		$this->sftp->delete($fileName);
	}

	public function deleteFolder($folderName)
	{
		$this->sftp->delete($folderName, true);
	}
}
