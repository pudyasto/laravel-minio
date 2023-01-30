<?php

namespace App\Http\Controllers;

use App\CustomClass\UploadFiles;
use App\Models\Uploader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UploadFileController extends Controller
{

    protected $message = 'Data berhasil di proses';
    protected $code = 200;
    protected $response = array();

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('upload-file.index', []);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }
        return view('upload-file.form', [
            'url' => url('/upload-file/store'),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!$request->ajax()) {
            return redirect('');
        }

        $validator = Validator::make($request->all(), [
            'file_name' => ['file','required'],
        ]);

        if ($validator->fails()) {
            throw new Exception (errorValidasi($validator->errors()));
        }

        if ($request->hasFile('file_name')) {
            // Jika ada upload gambar
            $minio = new UploadFiles();
            $file_name = $minio->upload($request, 'file_name',null,'minio');
        }

        $this->response = Uploader::create([
            'name'              => preg_replace('@[^0-9a-z\.]+@i', '-', strtolower($request->file('file_name')->getClientOriginalName())),
            'description'       => $request->description,
            'mime'              => $request->file('file_name')->getClientMimeType(),
            'ext'               => $request->file('file_name')->extension(),
            'size'              => $request->file('file_name')->getSize(),
            'location'          => $file_name,
        ]);

        $this->message = "Data berhasil disimpan";

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        try {
            if (!$request->ajax()) {
                return redirect('');
            }
            DB::beginTransaction();
            $location = Uploader::where('id', $request->id)->first();
            if($location){
                Storage::cloud()->delete($location->location);
                $this->response = Uploader::find($request->id)->delete();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $this->message = errorMessage($e->getMessage());
            $this->code = 500;
        }

        return response()->json([
            'metadata' => array(
                'message' => $this->message,
                'code' => $this->code,
            ),
            'response' => $this->response,
        ], $this->code);
    }

    public function tableMain(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('');
        }
        
        $table = Uploader::select([
            'name',
            'description',

            'mime',
            'ext',
            'size',
            
            'location',
            'id',
        ]);

        return DataTables::of($table)

            ->addColumn('btn', function ($data) {
                $file = new UploadFiles();
                $btn = '<center>' .
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Button Group">' .
                    '<a class="btn btn-primary btn-sm" target="_blank" href="'.$file->showFile($data->location).'">' .
                    '<i class="fa fa-eye"></i>' .
                    '</a>' . 
                    '<button class="btn btn-danger btn-sm"' .
                    ' onclick="deleteData(\'' . $data->id . '\');">' .
                    '<i class="fa fa-trash"></i>' .
                    '</button>' .
                    '</div>' .
                    '</center>';
                return $btn;
            })
            ->rawColumns(['btn'])
            ->make(true);
    }
}
