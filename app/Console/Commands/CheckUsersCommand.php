<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CheckUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and display current users with their info';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::withTrashed()->get();

        if ($users->isEmpty()) {
            $this->info('No users found in database.');
            return;
        }

        $this->info('Current users in database:');
        $this->table(
            ['ID', 'Name', 'Email', 'Role', 'Status', 'Password Hash Length'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role ?? 'N/A',
                    $user->trashed() ? 'Inactive' : 'Active',
                    strlen($user->password ?? ''),
                ];
            })
        );

        // Ask if user wants to set a password for the admin user
        if ($this->confirm('Do you want to set a password for the admin user (admin@admin.com)?')) {
            $password = $this->secret('Enter new password for admin user');
            $confirmPassword = $this->secret('Confirm password');

            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match!');
                return;
            }

            $user = User::where('email', 'admin@admin.com')->first();
            if ($user) {
                $user->password = Hash::make($password);
                $user->save();
                $this->info('Password updated successfully for admin@admin.com');
            } else {
                $this->error('Admin user not found!');
            }
        }

        return 0;
    }
}