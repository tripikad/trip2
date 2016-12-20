<?php

namespace App\Console\Commands;

use DB;
use App\User;
use Carbon\Carbon;

class ConvertUsers extends ConvertBase
{
    protected $signature = 'convert:users';

    public function getOldestComment($uid)
    {
        return DB::connection($this->connection)
            ->table('comments')
            ->where('uid', '=', $uid)
            ->min('timestamp');
    }

    public function getOldestContent($uid)
    {
        return DB::connection($this->connection)
            ->table('node')
            ->where('uid', '=', $uid)
            ->min('created');
    }

    public function calculateMin($first, $second)
    {
        if ($first < 1) {
            return $second;
        }
        if ($second < 1) {
            return $first;
        }

        return min($first, $second);
    }

    public function convertUsersOld()
    {
        $take = 60;
        $oldestUser = 903018060; // 13. aug 1998

        $userToFix = [1, 3, 5, 8, 10, 12, 15, 16, 20];

        $users = DB::connection($this->connection)
            ->table('users')
            ->where('uid', '>', 0)
            ->where('uid', '<', 60)
            ->orderBy('uid')
            ->pluck('uid');

        $this->info('Converting old users');

        $this->output->progressStart($take);

        foreach ($users as $uid) {
            $oldestContribution = $this->calculateMin(
                $this->getOldestContent($uid),
                $this->getOldestComment($uid)
            );

            $created = in_array($uid, $userToFix) ? $oldestUser : $oldestContribution;

            if (! $user = User::find($uid)) {
                $user = $this->getUser($uid);

                $user->created = $created;

                $this->createUser($user);
            } else {
                $user->created_at = $created;

                $user->save();
            }

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }

    public function convertUsersOther()
    {
        $lastLogged = Carbon::now()->subYears(1)->getTimestamp();

        $users = DB::connection($this->connection)
            ->table('users')
            ->where('uid', '>', 60)
            ->where('status', '=', 1)
            ->where('login', '>', $lastLogged)
            ->orderBy('uid', 'desc')
            ->take($this->take);

        $this->info('Converting other users');

        $this->output->progressStart($users->count());

        $i = 0;

        foreach ($users->pluck('uid') as $uid) {
            if (! User::find($uid)) {
                $this->convertUser($uid);

                // Removing homepage link from profile because of spam consideration

                if ($user = User::find($uid)) {
                    $user->update(['contact_homepage' => null]);
                }

                $i++;

                $this->output->progressAdvance();
            }
        }

        $this->output->progressFinish();

        $this->line("Converted $i users");
    }

    public function convertUsersDemo()
    {
        $demoUsers = [
            'regular',
            'admin',
            'superuser',
        ];
        $this->info('Converting demo users');

        $this->output->progressStart(count($demoUsers));

        $i = 0;
        foreach ($demoUsers as $role) {
            User::create([
                'name' => 'demo'.$role,
                'email' => $role.'@example.com',
                'password' => bcrypt('demo'.$role),
                'role' => $role,
                'verified' => 1,
            ]);

            ++$i;

            $this->output->progressAdvance();
        }

        $this->output->progressFinish();

        $this->line("Converted $i demo users");
    }

    public function handle()
    {
        $this->convertUsersOld();
        $this->convertUsersOther();

        if ($this->demoAccounts) {
            $this->convertUsersDemo();
        }
    }
}
