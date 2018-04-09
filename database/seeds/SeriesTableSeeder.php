<?php

use CodeFlix\Repositories\SerieRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class SeriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Collection $series */
        $series = factory(\CodeFlix\Models\Serie::class, 5)->create();
        $repository = app(SerieRepository::class);
        $collectionThumbs = $this->getThumbs();
        $series->each(function($serie) use($repository, $collectionThumbs){
            $repository->uploadThumb($serie->id, $collectionThumbs->random());
        });
    }

    protected function getThumbs()
    {
        return new \Illuminate\Support\Collection([
            new \Illuminate\Http\UploadedFile(
                storage_path('app\files\faker\thumbs\thumb_symfony.jpg'),
                'thumb_symfony.jpg'
            ),
            //se houver mais arquivos incluir no array, como no exemplo abaixo:
//            new \Illuminate\Http\UploadedFile(
//                storage_path('app/files/faker/thumbs/thumb_symfony.jpg'),
//                'thumbs_symfony.jpg'
//            ),
        ]);
    }
}