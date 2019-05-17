<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Mockery\Exception;

class FileService
{

    public function create($file, Model $model = null)
    {

        if (empty($file)) {
            return null;
        }

        if (!in_array($file->getClientOriginalExtension(), $model->getFileConfig()['allowed_extensions'])) {
            return new Exception('Extension not allowed');
        }

        if (isset($model->getFileConfig()['file_name'])) {

            $name = Str::slug($model->getFileConfig()['file_name']);

            $file_name = $name . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        }

        $file_name = time() . uniqid() . '.' . $file->getClientOriginalExtension();

        $file_path = public_path() . '/files';

        if (isset($model->getFileConfig()['file_path'])) {

            $file_path = public_path() . $model->getFileConfig()['file_path'];
        }

        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, 'true');
        }

        $file->move($file_path, $file_name);

        return [
            'file' =>  $model->getFileConfig()['file_path'] . '/' . $file_name
        ];
    }

    public function update($file, Model $model)
    {

        if (empty($file)) {
            return null;
        }

        if (!$file->getClientOriginalExtension() === 'pdf') {
            return new Exception('Extensão não permitida!');
        }

        File::delete([
            public_path() . $model->anexo
        ]);

        if (isset($model->getFileConfig()['file_name'])) {

            $name = Str::slug($model->getFileConfig()['file_name']);
            $file_name = $name . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        }

        $file_name = time() . uniqid() . '.' . $file->getClientOriginalExtension();


        $file_path = public_path() . '/files';

        if (isset($model->getFileConfig()['file_path'])) {

            $file_path = public_path() . $model->getFileConfig()['file_path'];
        }

        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }

        $file->move($file_path, $file_name);

        return [
            'file' => $model->getFileConfig()['file_path'] . '/' . $file_name,
        ];
    }

    public function delete(Model $model)
    {
        File::delete([
            public_path() . $model->anexo
        ]);
    }
}

