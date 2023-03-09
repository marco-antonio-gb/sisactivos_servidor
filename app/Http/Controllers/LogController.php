<?php

namespace App\Http\Controllers;

use File;

use ZipArchive;

class LogController extends Controller
{

	public function parseLog($log_folder)
	{
		$path          = public_path('/home/logs/' . strtolower($log_folder));
		$logCollection = [];
		$files         = File::files($path);
		foreach ($files as $key => $file) {
			$logCollection[] = $file->getFilename();
		}
		$total = count($logCollection);
		$slice_array = array_slice($logCollection, -5);
		return [
			'total' => $total,
			'remaining' => $total - count($slice_array),
			'log_list' => $slice_array
		];
	}

	public function getLogFile()
	{

		return response()->json([
			'login'          => $this->parseLog('login'),
			'responsables'   => $this->parseLog('responsables'),
			'articulos'      => $this->parseLog('articulos'),
			'usuarios'       => $this->parseLog('usuarios'),
			'asignaciones'   => $this->parseLog('asignaciones'),
			'bajas'          => $this->parseLog('bajas'),
			'transferencias' => $this->parseLog('transferencias'),
		], 200);
	}

	public function DownloadLogFile($folder)
	{
		$zip = new ZipArchive;

		$fileName = $folder . '.zip';
		$path          = public_path('/home/logs/' . strtolower($folder));
		if (File::isDirectory($path)) {
			$files         = File::files($path);
			if (count($files) > 0) {
				if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
					$files = \File::files($path);
					foreach ($files as $key => $value) {
						$file = basename($value);
						$zip->addFile($value, $file);
					}
					$zip->close();
				}
				return response()->download(public_path($fileName));
			}
			return response()->json([
				'success' => false,
				'message' => 'Sin archivos en la carpeta'
			], 200);
		}
		return response()->json([
			'success' => false,
			'message' => 'La carpeta no existe'
		], 200);
	}
}
