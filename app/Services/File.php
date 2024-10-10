<?php

namespace App\Services;

class File
{
    /**
    * Переименование файла
    * @param string
    * @param Illuminate\Http\UploadedFile object 
    * @param string
    * @return string
    */
    public function rename_file($slug, $file, $folder = '')
    {   
        if ($folder) {
            $folder = $folder . '/';
        }
        
        $mimetype = $file->getMimeType();
        $extension = $file->getClientOriginalExtension();

        // $filetype = \App\Http\Controllers\Admin\AdminController::file_type($mimetype, $extension);
        $filetype = self::file_type($mimetype, $extension);

        $new_filename = $slug . '-' . date('dmY') . '-' . mt_rand() . $filetype;
        $tmppathfilename = $file->getPathname();
        $pathname = public_path('storage') . "/uploads/" . $folder . $new_filename;
        $pathnametobase = $new_filename;
        move_uploaded_file($tmppathfilename, $pathname);

        return $pathnametobase;
    }

    /**
     * Получение расширения файла filetype
     */
    public function file_type($mimetype, $extension)
    {
        $filetype = "";
        switch ($mimetype) {
            case "image/jpeg":
                $filetype = ".jpg";
                break;
            case "image/png":
                $filetype = ".png";
                break;
            case "image/gif":
                $filetype = ".gif";
                break;
            case "image/webp":
                $filetype = ".webp";
                break;
            case "application/pdf":
                $filetype = ".pdf";
                break;
            case "application/msword":
                $filetype = ".doc";
                break;
            case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
                $filetype = ".docx";
                break;
            case "application/vnd.ms-excel":
                $filetype = ".xls";
                break;
            // xlsx определяется как octet-stream
            case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                $filetype = ".xlsx";
                break;
            case "application/octet-stream":
                if($extension == "xlsx") {
                    $filetype = ".xlsx";
                }
                break;
            default:
                $filetype = ".other";
        }

        return $filetype;
    }
}