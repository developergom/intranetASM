<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use DB;

class SendLogsEmailConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logsemail:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a logs user to email..';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $data = array();

        $data['waktu'] = date('Y-m-d H:i:s');
        $data['logs'] = DB::table('logs')->select(DB::raw('user_name,user_firstname,user_lastname,count(log_id) AS total'))->join('users', 'users.user_id', '=', 'logs.created_by')->whereBetween('logs.created_at', [date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59'])->get();

        Mail::send('vendor.material.mail.logsemail', array('data'=>$data), function($message) {
            $message->to('soni@gramedia-majalah.com', 'Soni Rahayu')->subject('Intranet ASM Logs');
            //$message->bcc('soni@gramedia-majalah.com', 'Administrator');
            //$message->attach('public/img/profile-menu.png');
        });
    }
}
