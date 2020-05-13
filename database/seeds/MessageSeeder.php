<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Models\User;
use App\Http\Models\Message;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 20)->create()->each(function (User $user) {
            $user->messages()->saveMany(
                factory(Message::class, 20)->make(['recipient_id' => $user->id]));
        });
    }
}
