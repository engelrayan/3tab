<?php

namespace Database\Seeders;

use App\Models\Atab;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
 
    public function run(): void
    {
        $rayan = User::factory()->create([
            'name' => 'Rayan',
            'username' => 'rayan',
            'email' => 'rayan@example.com',
            'bio' => 'Just vibing. Send me your honest thoughts.',
            'mood' => 'chill',
            'allow_anonymous' => true,
        ]);
 
        // 8 anonymous atabs
        Atab::factory(8)->create([
            'recipient_id' => $rayan->id,
            'is_anonymous' => true,
            'sender_id' => null,
        ]);
 
        // 2 named atabs from a random sender
        $sender = User::factory()->create();
        Atab::factory(2)->create([
            'recipient_id' => $rayan->id,
            'sender_id' => $sender->id,
            'is_anonymous' => false,
        ]);
    }
}