<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 06/03/2018
 * Time: 19:34
 */

namespace CodeFlix\Media;


trait VideoPaths
{
    /**
     * trait
     */
    use ThumbPaths;

    /**
     * gera pasta da imagem
     * @return string
     */
    public function getThumbFolderStorageAttribute()
    {
        return "videos/{$this->id}";
    }

    /**
     * gera pasta da imagem
     * @return string
     */
    public function getFileFolderStorageAttribute()
    {
        return "videos/{$this->id}";
    }

    /**
     * caminho para download da imagem no frontend
     * a imagem não tem acesso absoluto
     * @return string
     */
    public function getFileAssetAttribute()
    {
        return $this->isLocalDrive() ?
            route('admin.videos.file_asset', ['video' => $this->id]) :
            $this->file_path;
    }

    /**
     * define o nome do thumb default
     * @return mixed
     */
    public function getFileDefaultAttribute()
    {
        return env('VIDEO_NO_THUMB');
    }

    public function getFileRelativeAttribute()
    {
        return $this->file ? "{$this->file_folder_storage}/{$this->file}" : false;
    }

    public function getFilePathAttribute()
    {
        if($this->file_relative){
            return $this->getAbsolutePath($this->getStorage(), $this->file_relative);
        }
        return false;
    }

    /**
     * caminho para download da imagem no frontend
     * a imagem não tem acesso absoluto
     * @return string
     */
    public function getThumbAssetAttribute()
    {
        return $this->isLocalDrive() ?
            route('admin.videos.thumb_asset', ['video' => $this->id]) :
            $this->thumb_path;
    }

    /**
     * caminho para download da imagem no frontend
     * a imagem não tem acesso absoluto
     * @return string
     */
    public function getThumbSmallAssetAttribute()
    {
        return $this->isLocalDrive() ?
            route('admin.videos.thumb_small_asset', ['video' => $this->id]) :
            $this->thumb_small_path;
    }
}