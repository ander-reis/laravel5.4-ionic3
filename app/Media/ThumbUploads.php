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

trait ThumbUploads
{
    /**
     * upload do thumbnail
     * @param $id
     * @param UploadedFile $file
     * @return mixed
     */
    public function uploadThumb($id, UploadedFile $file)
    {
        //consulta id
        $model = $this->find($id);
        //retorna collection
        $name = $this->upload($model, $file, 'thumb');
        if($name){
            //verifica se existe arquivo e deleta
            $this->deleteThumbOld($model);
            //faz nova atribuição do thumb
            $model->thumb = $name;
            //retorna thumbnail small
            $this->makeThumbSamll($model);
            //salva thumbnail
            $model->save();
        }
        //se houve erro retorna false/erro
        return $model;
    }

    /**
     * faz thmubnail small
     * @param $model
     */
    protected function makeThumbSamll($model)
    {
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();
        //retorna caminho para salvar imagem
        $thumbFile = $model->thumb_path;
        //pega formato da imagem
        $format = \Image::format($thumbFile);
        //pega formato small da imagem e configura box
        $thumbnailSmall = \Image::open($thumbFile)->thumbnail(new Box(64, 36));
        //inclui imagem no storage
        $storage->put($model->thumb_small_relative, $thumbnailSmall->get($format));
    }

     /**
     * exclui imagem da pasta de upload
     * @param $model
     */
    public function deleteThumbOld($model)
    {
        /** @var FilesystemAdapter $storage */
        $storage = $model->getStorage();

        //verifica se imagem existe na pasta na hora da edição
        if($storage->exists($model->thumb_relative) && $model->thumb != $model->thumb_default){
            $storage->delete([$model->thumb_relative, $model->thumb_small_relative]);
        }
    }
}