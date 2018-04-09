<?php

use CodeFlix\Models\User;
use Illuminate\Database\Migrations\Migration;

class CreateUserAdminData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $model = User::create([
            'name' => env('ADMIN_DEFAULT_NAME', 'Administrator'),
            'email' => env('ADMIN_DEFAULT_EMAIL', 'admin@user.com'),
            'password' => bcrypt(env('ADMIN_DEFAULT_PASSWORD', 'secret')),
            'role' => User::ROLE_ADMIN
        ]);
        $model->verified = true;
        $model->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = (new User())->getTable();
        \DB::table($table)
            ->where('email', '=', env('ADMIN_DEFAULT_EMAIL', 'admin@user.com'))
            ->delete();
    }
}
