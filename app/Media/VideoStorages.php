<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 06/03/2018
 * Time: 19:29
 */

namespace CodeFlix\Media;


use Illuminate\Filesystem\FilesystemAdapter;

trait VideoStorages
{

    /**
     * @return \Illuminate\Filesystem\FilesystemAdapter
     */
    public function getStorage(){
        return \Storage::disk($this->getDiskDriver());
    }

    //driver
    protected  function getDiskDriver(){
        return config('filesystems.default');
    }

    protected function getAbsolutePath(FilesystemAdapter $storage, $fileRelativePath)
    {
        return $this->isLocalDrive() ?
            $storage->getDriver()->getAdapter()->applyPathPrefix($fileRelativePath) :
            $storage->url($fileRelativePath);
    }

    public function isLocalDrive()
    {
        $driver = config("filesystems.disks.{$this->getDiskDriver()}.driver");
        return $driver == 'local';
    }
}