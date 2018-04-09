<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 06/03/2018
 * Time: 19:34
 */

namespace CodeFlix\Media;


trait SeriePaths
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
        return "series/{$this->id}";
    }

    /**
     * caminho para download da imagem no frontend
     * a imagem não tem acesso absoluto
     * @return string
     */
    public function getThumbAssetAttribute()
    {
        return $this->isLocalDrive() ?
            route('admin.series.thumb_asset', ['serie' => $this->id]) :
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
            route('admin.series.thumb_small_asset', ['serie' => $this->id]) :
            $this->thumb_small_path;
    }

    /**
     * define o nome do thumb default
     * @return mixed
     */
    public function getThumbDefaultAttribute()
    {
        return env('SERIE_NO_THUMB');
    }
}