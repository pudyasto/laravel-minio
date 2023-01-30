<?php

namespace App\CustomClass;

use App\Models\Uploader;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

// Class untuk Minio

class UploadFiles
{

    protected $local_path;

    public function __construct()
    {
        $this->local_path = env('LOCAL_PATH');

        if (!$this->local_path) {
            $this->local_path = storage_path('files/');
        }
    }

    public function upload($request, $input_name = 'lampiran', $mimes = 'mimes:jpg,bmp,png', $driver = null)
    {
        if ($request->hasFile($input_name)) {
            $validator = Validator::make($request->all(), [
                $input_name => ['file', $mimes],
            ]);

            if ($validator->fails()) {
                throw new Exception(errorValidasi($validator->errors()));
            }

            $file = $request->file($input_name);

            // $guessExtension = $file->guessExtension();
            $filename = preg_replace('@[^0-9a-z\.]+@i', '-', strtolower($file->getClientOriginalName()));

            if (!$driver) {
                $file->move($this->local_path,  $filename);
                return $this->local_path . $filename;
            } else {
                $path = Storage::cloud()->put($input_name, $file);
                return $path;
            }
        }
    }

    public function getCloudFile($path)
    {
        $data = Storage::cloud()->temporaryUrl($path, \Carbon\Carbon::now()->addMinutes(1));
        return $data;
    }
    
    public function showFile($filename)
    {
        $data = Uploader::where('location', $filename)->first();

        if ($data->location) {
            if (Storage::cloud()->exists($filename)) {
                return Storage::cloud()->temporaryUrl(
                    $data->location,
                    \Carbon\Carbon::now()->addMinutes(5),
                    [
                        'ResponseContentType' => 'application/octet-stream',
                        'ResponseContentDisposition' => 'attachment; filename=' . $data->name,
                    ]
                );
            }
        }
    }

    public function getLocalFile($location_id)
    {
        $file = glob($location_id);
        if (count($file)) {
            $photo = $file[0];
        } else {
            $photo = public_path('images/user.png');
        }

        $data = fopen($photo, 'rb');
        $size = filesize($photo);
        $contents = fread($data, $size);
        fclose($data);
        return $contents;
    }
}
