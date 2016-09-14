<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UploadFile;

class DownloadController extends Controller
{
    public function downloadFile($id) {
    	$file = UploadFile::find($id);

    	/*dd($file);*/

    	$path = $file->upload_file_path . '/' . $file->upload_file_name;

    	return response()->download($path);
    }
}
