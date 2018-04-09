<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 11/03/2018
 * Time: 16:11
 */

namespace CodeFlix\Media;


use Illuminate\Http\UploadedFile;

trait Uploads
{
    /**
     * faz ação do upload
     * @param $model
     * @param UploadedFile $file
     * @return false|string
     */
    protected function upload($model, UploadedFile $file, $type)
    {
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();
        //cria nome para imagem
        $name = md5(time() . "{$model->id}-{$file->getClientOriginalName()}") . ".{$file->guessExtension()}";
        //faz upload
        $result = $storage->putFileAs($model->{"{$type}_folder_storage"}, $file, $name);
        //retorna nome com sucesso ou resultado de erro
        return $result ? $name : $result;
    }
}