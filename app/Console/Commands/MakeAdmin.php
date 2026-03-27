<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    protected $signature = 'admin:make {identifier : Email or username of the user}';
    protected $description = 'Grant admin privileges to a user by email or username';

    public function handle(): int
    {
        $identifier = $this->argument('identifier');

        $user = User::where('email', $identifier)
                    ->orWhere('username', $identifier)
                    ->first();

        if (! $user) {
            $this->error("❌ لا يوجد مستخدم بهذا الإيميل أو اليوزرنيم: {$identifier}");
            return self::FAILURE;
        }

        if ($user->is_admin) {
            $this->warn("⚠️  {$user->name} ({$user->email}) هو أدمن بالفعل.");
            return self::SUCCESS;
        }

        $user->update(['is_admin' => true]);

        $this->info("✅ تم تعيين {$user->name} ({$user->email}) أدمناً بنجاح.");
        $this->line("   🔗 رابط لوحة الإدارة: " . url('/admin'));

        return self::SUCCESS;
    }
}
