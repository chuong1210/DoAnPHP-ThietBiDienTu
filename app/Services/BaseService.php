<?php

namespace App\Services;

use App\Repositories\RouterRepository;
use App\Services\Interfaces\BaseServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    protected $model;

    public function __construct() {}


    public function formatAlbum($album)
    {
        // $payload['album']: mảng các đường dẫn từ input name="album[]"
        return (isset($album) && is_array($album)) ? json_encode($album) : "";
    }

    public function nestedset($nestedset)
    {
        // tính giá trị left, right bằng Nestedsetbie (có sẵn)
        $nestedset->Get('level ASC, order ASC');
        $nestedset->Recursive(0, $nestedset->Set());
        $nestedset->Action();
    }
    public function formatRouterPayload($model, $request, $controllerName, $languageId)
    {
        return [
            'canonical' => Str::slug($request->input('canonical')), //chuyển đổi một chuỗi văn bản thành dạng mà có thể sử dụng được trong URL
            'module_id' => $model->id,
            'controllers' => 'App\Http\Controllers\client\\' . $controllerName . '',
            'language_id' => $languageId,
        ];
    }

    public function formatJson($request, $inputName)
    {
        return $request->input($inputName) && !empty($request->input($inputName)) ? json_encode($request->input($inputName)) : '';
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $model = lcfirst($post['model']);
            $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);
            $this->{$model . "Repository"}->update($post['modelId'], $payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateStatusAll($post = [])
    {
        DB::beginTransaction();
        try {
            $model = lcfirst($post['model']);
            $payload[$post['field']] = $post['value'];
            $this->{$model . "Repository"}->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
