<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * código foi comentado a partir do vídeo Listando vídeos pela API
         */
//        $users = app(\CodeFlix\Repositories\UserRepository::class)->all();
        $orders = factory(\CodeFlix\Models\Order::class, 30)->make();
        $order = $orders->first();
        $order->user_id = 1;
        $order->save();
//        $orders->each(function($order) use($users){
//            $order->user_id = $users->random()->id;
//            $order->save();
//        });
    }
}
