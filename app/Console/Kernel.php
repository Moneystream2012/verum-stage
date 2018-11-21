<?php

namespace App\Console;

//use App\Amount;
use App\Jobs\SmsNotify;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ComputeDeposits::class,
        Commands\ComputeRewards::class,
        Commands\ComputeMatching::class,
        Commands\ComputeTrading::class,
        Commands\UpdateReplenishment::class,
        Commands\CheckTeamDevelopers::class,
        Commands\CheckPremiumRanks::class,
        Commands\WalletNotify::class,
        Commands\BlockNotify::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('queue:work --sleep=3 --tries=3 --once')
            ->evenInMaintenanceMode()
            ->everyMinute();

        $schedule->command('compute:deposits')
            ->evenInMaintenanceMode()
            ->everyMinute();

        $schedule->command('compute:trading')
            ->evenInMaintenanceMode()
            ->everyMinute();
        /*
                $schedule->command('compute:rewards')
                    ->evenInMaintenanceMode()
                    ->weekly()->mondays()->at('09:00')
                    ->appendOutputTo(storage_path('logs/compute_rewards.log'));

                $schedule->command('compute:matching')
                    ->evenInMaintenanceMode()
                    ->weekly()->mondays()->at('18:00')
                    ->appendOutputTo(storage_path('logs/compute_matching.log'));

                $schedule->command('check:team-developers')
                    ->evenInMaintenanceMode()
                    ->weekly()->sundays()->at('03:00')
                    ->appendOutputTo(storage_path('logs/check_team-developers.log'));

                $schedule->command('check:premium-ranks')
                    ->evenInMaintenanceMode()
                    ->weekly()->mondays()->at('13:00')
                    ->appendOutputTo(storage_path('logs/check_premium-rank.log'));*/

//        $schedule->call(function () {
////            Amount::typeIncrement('ico_telegram_fake', random_int(5000, 10000));
//
//            $users = User::whereBetween('created_at', [Carbon::now()->subMonths(2), Carbon::now()])->get();
////            dd($users->count());
//            $users->each(function ($user) {
//                if (!$user->is_investor) {
//                    dispatch(new SmsNotify($user, 'user-not-48', ['amount' => 10]));
//                }
////                dump($user->is_investor);
//            });
//        })->cron('0 23 */2 * *');
    }

    /**
     * Register the Closure based commands for the application.
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
