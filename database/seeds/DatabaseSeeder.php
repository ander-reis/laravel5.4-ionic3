<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * faz a exclusão do diretorio de upload
         */
        $rootPath = config('filesystems.disks.videos_local.root');
        \File::deleteDirectory($rootPath, true);

        /**
         * chamada da seeders
         */
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(SeriesTableSeeder::class);
        $this->call(VideosTableSeeder::class);
    }
}
