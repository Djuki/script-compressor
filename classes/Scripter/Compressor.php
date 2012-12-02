<?php


namespace Scripter;

define ('COMPRESSOR_LIB_PATH', dirname(__FILE__) );


class Compressor
{
	/**
	 * Javascript compression
	 * @var string
	 */
	const COMPRESSON_TYPE_JS = 'js';

	/**
	 * Css compression
	 * @var string
	 */
	const COMPRESSION_TYPE_CSS = 'css';

	/**
	 * Active compression type
	 * @var string
	 */
	protected $compressionType;

	/**
	 * Path of compressed file
	 * @var string
	 */
	protected $compressedFilePath;

	/**
	 * Original content from all files
	 * @var string
	 */
	protected $filesContent;
	
	/**
	 * Path to java YUI compressor
	 * @var unknown_type
	 */
	protected $yuiCompressorPath;


	/**
	 * Create compression object
	 * @param string $compression_type
	 */
	public function __construct($compressionType = self::COMPRESSON_TYPE_JS)
	{
		$this->compressionType = $compressionType;

		$this->yuiCompressorPath = COMPRESSOR_LIB_PATH.'/../../yuicompressor/yuicompressor-2.4.2.jar';
	}



	public function getCompressedFile($files)
	{
		if ($this->isOldFile())
		{
			// Jets compress again
		}

		return ;
	}

	public function compressFiles($files, $oneFile = false)
	{
		if ($oneFile)
		{
			foreach ($files as $file)
			{
				$this->filesContent .= file_get_contents($file);
			}

			$compressMe = $oneFile.$this->getCompressedFileName($files).'.'.$this->compressionType;
			$compressedFile = $oneFile.$this->getCompressedFileName($files).'.min.'.$this->compressionType;

			file_put_contents($compressMe, $this->filesContent);

			$this->compressFile($compressMe, $compressedFile);
		}
		else
		{
			foreach ($files as $file)
			{
				$pathInfo = pathinfo($file);
				$destinationFile = $pathInfo['dirname'].'/'.$pathInfo['filename'].'.min.'.$pathInfo['extension'];
				
				$this->compressFile($file, $destinationFile);
				
			}
		}



	}

	/**
	 * Crypt file name to ensure we have unique compressed file for every group of files
	 * @param array $files
	 *
	 * @return string
	 */
	private function getCompressedFileName($files, $oneFile = true)
	{
		if ($oneFile)
		{
			return md5(implode($files));
		}

		foreach ($files as $key => $fileName)
		{
			$files[$key] = md5($fileName);
		}

		return $files;
	}


	private function compressFile($originalFile, $destinationFile)
	{
		var_dump("java -jar ".$this->yuiCompressorPath." -o '".$destinationFile."' '".$originalFile."'");exit;
		eval("java -jar ".$this->yuiCompressorPath." -o '".$destinationFile."' '".$originalFile."'");
	}
}