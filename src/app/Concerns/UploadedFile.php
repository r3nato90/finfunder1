<?php

namespace App\Concerns;

use Illuminate\Support\Str;

trait UploadedFile
{
    public function move(\Illuminate\Http\UploadedFile $file, string $directory = null, ?string $isRemoveFile = null): ?string
    {
        try {

            $directory = 'assets/files/';

            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            if ($isRemoveFile && file_exists($directory . '/' . $isRemoveFile) && is_file($directory . '/' . $isRemoveFile)) {
                @unlink($directory . '/' . $isRemoveFile);
            }

            $name = Str::random() . '.' . $file->getClientOriginalExtension();

            $file->move($directory, $name);
            $this->setFilePermissions($directory . '/' . $name);
            return $name;
        }catch (\Exception $exception){
            return null;
        }
    }


    private function setFilePermissions(string $filePath): void
    {
        chmod($filePath, 0777);
    }


}
