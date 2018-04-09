<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 10/03/2018
 * Time: 13:15
 */

namespace CodeFlix\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Filesystem\FilesystemAdapter;
use Imagine\Image\Box;

trait VideoUploads
{
    /**
     * upload do thumbnail
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadFile($id, UploadedFile $file)
    {
        //consulta id
        $model = $this->find($id);
        //retorna collection
        $name = $this->upload($model, $file, 'file');
        if($name){
            //verifica se existe arquivo e deleta
            $this->deleteFileOld($model);
            //faz nova atribuição do thumb
            $model->file = $name;
            //salva thumbnail
            $model->save();
        }
        //se houve erro retorna false/erro
        return $model;
    }

    /**
     * exclui imagem da pasta de upload
     * @param $model
     */
    public function deleteFileOld($model)
    {
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();

        //verifica se video existe na pasta na hora da edição
        if($storage->exists($model->file_relative)){
            $storage->delete($model->file_relative);
        }
    }

}