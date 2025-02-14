<?php

namespace App\Http\Requests\Upload;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function rules(): array
    {
        $route = request()->route()->getName();
        if ($route == 'upload.image') {
            $rule = 'max:10240|image';
        } elseif ($route == 'upload.video') {
            $rule = 'max:40960|mimetypes:video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv';
        }elseif($route == 'upload.apk'){
            $rule = 'mimetypes:application/zip,apk|max:204800,max:204800';
        }elseif($route == 'upload.pdf'){
            $rule = 'mimes:pdf|max:20480';
        }elseif($route == 'upload.excel'){
            $rule = 'mimes:xlsx,xls,csv';
        }else {
            $rule = 'max:10240';
        }

        return [
            'file' => 'required|file|' . $rule
        ];
    }
}
