<?php

use Illuminate\Database\Seeder;
use App\Notification;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::insert([
            [ 'type_id' => '1', 'receive_id' => '2', 'send_id' => '5', 'review_id' => '1'],
            [ 'type_id' => '2', 'receive_id' => '2', 'send_id' => '5', 'review_id' => '2'],
            [ 'type_id' => '3', 'receive_id' => '2', 'send_id' => '5', 'review_id' => null]
        ]);
    }
}
