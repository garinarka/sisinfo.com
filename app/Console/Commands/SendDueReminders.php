<?php

namespace App\Console\Commands;

use App\Models\BookLoan;
use App\Notifications\BookDueReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendDueReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'library:send-due-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for books due soon';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dueSoonLoans = BookLoan::with(['user', 'book'])
            ->whereNull('returned_date')
            ->where('due_date', '>', Carbon::now())
            ->where('due_date', '<=', Carbon::now()->addDays(3))
            ->whereDoesntHave('user.notifications', function ($query) {
                $query->where('type', BookDueReminder::class)
                    ->where('created_at', '>=', Carbon::now()->subDays(1));
            })
            ->get();

        foreach ($dueSoonLoans as $loan) {
            $loan->user->notify(new BookDueReminder($loan->book, $loan));
        }

        $this->info("Sent {$dueSoonLoans->count()} due date reminders.");
    }
}
