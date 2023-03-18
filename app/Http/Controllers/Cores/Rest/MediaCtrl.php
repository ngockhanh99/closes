<?php

namespace App\Http\Controllers\Cores\Rest;

use App\Models\Sipas\SipasQuestionFormValueModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Cores\Cores_Media;
use App\Models\Cores\Cores_user_meta;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MediaCtrl extends Controller
{

    /**
     * Upload file
     * @param Request $request
     * @return type
     */
    function upload(Request $request)
    {
        if (!$request->hasFile('myfile')) {
            return response()->json(['msgErr' => 'Không tài liệu nào được chọn'], 422);
        }

        //Lưu file theo cấu trúc: /năm/ou_{Mã đơn vị}
        $v_year   = date('Y');
        $v_mounth = date('m');
        $v_user_id = Auth::user()->id;

        $v_file_extension = $request->myfile->extension();
        try {
            $path = Storage::disk('public')->putFile("all/$v_year/$v_mounth", $request->file('myfile'));
        } catch (\Exception $ex) {
            return response()->json(['msgErr' => $ex->getMessage(), 'detail' => $ex->getTraceAsString()], 422);
        }

        $v_media_id = Cores_Media::insertGetId([
            'filename'   => $request->fileName,
            'filepath'   => $path,
            'file_ext'   => $v_file_extension,
            'user_id'    => $v_user_id,
            'created_at' => Carbon::now(),
        ]);
        $data     = [
            'id'         => $v_media_id,
            'filename'   => $request->fileName,
            'filepath'   => $path,
            'file_ext'   => $v_file_extension,
            'user_id'    => $v_user_id,
            'user_name'  => Auth::user()->user_name,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => NULL,
        ];
        return response()->json($data);
    }


    /**
     * Cập nhật ghi âm
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadMobile(Request $request)
    {
        $v_file_extension = $request->photo->getClientOriginalExtension();
        $v_file_extension = $v_file_extension ? $v_file_extension : $request->photo->extension();
        $name =  sha1(time()) . '.' . $v_file_extension;
        try
        {
            $v_year   = date('Y');
            $v_mounth = date('m');
            $path = Storage::disk('public')->putFileAs("all/$v_year/$v_mounth", $request->file('photo'), $name);
        }
        catch (\Exception $ex)
        {
            return response()->json(['msgErr' => $ex->getMessage(), 'detail' => $ex->getTraceAsString()], 422);
        }

        $v_media_id = Cores_Media::insertGetId([
            'filename'   => $name,
            'filepath'   => 'storage/' . $path,
            'file_ext'   => $v_file_extension,
            'user_id'    =>Auth::user()->id ?? 0,
            'created_at' => Carbon::now(),
        ]);

        $data     = [
            'id'         => $v_media_id,
            'filename'   => $name,
            'filepath'   => 'storage/' . $path,
            'file_ext'   => $v_file_extension,
            'user_id'    => Auth::user()->id ?? 0,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => NULL,
        ];
        return response()->json($data);
    }

    function insert(Request $request)
    {
        $arr_file = is_array($request->arr_file) ? $request->arr_file : [];
        $data     = [];
        foreach ($arr_file as $file) {
            $path             = $file['url'];
            $fileName         = $file['name'];
            $v_file_extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $url_prefix       = config('filesystems.disks.public.url');
            $v_user_id        = Auth::user()->id;
            $arrPathFile      = explode($url_prefix, $path);
            $pathfile         = end($arrPathFile);
            $pathfile         = trim($pathfile, '/');

            $v_media_id = Cores_Media::insertGetId([
                'filename'   => $fileName,
                'filepath'   => $pathfile,
                'file_ext'   => $v_file_extension,
                'user_id'    => $v_user_id,
                'created_at' => Carbon::now(),
            ]);
            $data[]     = [
                'id'         => $v_media_id,
                'filename'   => $fileName,
                'filepath'   => $pathfile,
                'file_ext'   => $v_file_extension,
                'user_id'    => $v_user_id,
                'user_name'  => Auth::user()->user_name,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => NULL,
            ];
        }
        return response()->json($data);
    }

    /**
     * Chỉ hiển thị danh sách file do nsd đó tải lên
     * Nếu là admin => show all files
     *
     * @OA\Get(path="/rest/media",
     *   tags={"Media"},
     *   summary="Danh sách file",
     *   description="",
     *   operationId="getAllMedia",
     *
     *   @OA\Response(response=200, description="successful operation"),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=404, description="User not found")
     * )
     */
    function allFiles(Request $request, Cores_Media $mediaModel)
    {
        $is_admin  = Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $v_user_id = Auth::user()->id;
        $year      = $request->year;
        $allFiles  = $mediaModel->allFiles($is_admin, $v_user_id, $year);
        return response()->json($allFiles);
    }

    /**
     * Lấy danh sách năm
     * Nếu là admin => show all files
     *
     * @OA\Get(path="/rest/media/all-year",
     *   tags={"Media"},
     *   summary="Danh sách năm có tài liệu file",
     *   description="",
     *   operationId="getAllYear",
     *
     *   @OA\Response(response=200, description="successful operation"),
     *   @OA\Response(response=400, description="Invalid username supplied"),
     *   @OA\Response(response=404, description="User not found")
     * )
     */
    function allYear(Cores_Media $mediaModel)
    {
        $is_admin  = Auth::user()->user_is_admin == 1 ? TRUE : FALSE;
        $v_user_id = Auth::user()->id;
        return $mediaModel->allYear($is_admin, $v_user_id);
    }

    /**
     *
     * @param Request $request
     * @return type
     */
    function downloadFile(Request $request)
    {
        ob_end_clean();
        $ext       = pathinfo($request->filename, PATHINFO_EXTENSION);
        $name      = pathinfo($request->filename, PATHINFO_FILENAME);
        $file_name = str_slug($name) . '.' . $ext;
        return Storage::download($request->filepath, $file_name);
    }

    function destroy($id)
    {
        $mediaInfo = Cores_Media::findOrFail($id);
        if ($mediaInfo->user_id != Auth::user()->id) {
            return response()->json(['message' => 'Không được xóa tài liệu của cán bộ khác'], 422);
        }
        //        Cores_Media::destroy($id);
    }

    public function uploadFile(Request $request)
    {
        $files = $request->file('files');
        if (!$files) return response()->json(['error' => 'File empty!']);
        $list_file = [];

        foreach ($files as $file) {
            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = Str::upper($file->getClientOriginalExtension());
            $path = $file->storeAs("public/all/" . date('Y') . "/" . date('m'), Str::random(40) . '.' . $extension);
            $path = str_replace('public', 'storage', $path);

            $media = Cores_Media::create([
                'filename' => $name,
                'filepath' => $path,
                'file_ext' => $extension,
                'user_id' => Auth::id(),
            ]);
            array_push($list_file, $media);
        }

        return response()->json($list_file);
    }
    public function uploadCkeditor(Request $request)
    {
        $file = $request->file('upload');
        $fileName = $file->getClientOriginalName();
        $v_year   = date('Y');
        $v_mounth = date('m');
        $v_user_id = Auth::user()->id;

        $v_file_extension = $request->upload->extension();
        try {
            $path = Storage::disk('public')->putFile("all/$v_year/$v_mounth", $request->file('upload'));
        } catch (\Exception $ex) {
            return response()->json(['msgErr' => $ex->getMessage(), 'detail' => $ex->getTraceAsString()], 422);
        }

        /**
         * @var UploadFileValidators $valid
         */

        $data     = [
            'fileName'   => $fileName,
            'url'   => url('/') . Storage::url($path),
            'uploaded'   => 1,
        ];
        return response()->json($data);
    }
}
