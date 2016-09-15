<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UploadFile;
use App\Download;

use BrowserDetect;

class DownloadController extends Controller
{
    public function downloadFile(Request $request, $id) {
    	$file = UploadFile::find($id);

    	$path = $file->upload_file_path . '/' . $file->upload_file_name;

        $browser = BrowserDetect::detect();

    	$download = new Download;
    	$download->upload_file_id = $id;
    	$download->download_ip = $request->ip();
    	$download->download_os = $browser->osFamily;
        $download->download_device = $browser->deviceFamily;
    	$download->download_browser = $browser->browserFamily;
    	$download->created_by = $request->user()->user_id;
    	$download->save();

    	return response()->download($path);
    }
}
