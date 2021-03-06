<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Mail;
use DB;
use Cache;
use Carbon\Carbon;

use App\Setting;
use App\User;

use App\Ibrol\Libraries\GeneralLibrary;
use App\Ibrol\Libraries\ReportXls;
use App\Ibrol\Libraries\UserLibrary;

class SendSalesPerformanceEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesperformance:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job to automatically generate sales performance report.';

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
        $setting_user_get_sales_report = Setting::where('setting_code', 'user_get_sales_report')->where('active', '1')->first();
        $users_cache = $setting_user_get_sales_report->setting_value;

        $gl = new GeneralLibrary;
        $ul = new UserLibrary;

        $users = explode('|', $users_cache);
        
        $date = Carbon::now();
        $month = $date->subMonth()->format('m'); //get prev month
        $year = $date->subMonth()->format('Y');
        $lastmonthdate = $gl->getMonthDate($month, $year);

        foreach ($users as $value) {
            $attachs = array();

            $data = array();
            $data['month'] = $month;
            $data['year'] = $year;
            $data['user'] = User::where('user_name', $value)->first();
            $subordinate = $ul->getUserSubordinate($data['user']->user_id);

            foreach($subordinate as $sub)
            {
                $filename = 'sales_performance_' . $sub->user_name . '_' . $sub->user_firstname . '_' . $sub->user_lastname . '_' . date('YmdHis');
                $report = new ReportXls;
                $report->generateSalesPerformance($filename, $sub->user_name, $lastmonthdate['start'], $lastmonthdate['end']);
                array_push($attachs, $filename);
            }
            
            Mail::send('vendor.material.mail.sales_performance', array('data'=>$data), function($message) use($attachs, $data){
                $message->to($data['user']->user_email, $data['user']->user_firstname)->subject('Sales Performance ' . $data['month'] . '/' . $data['year']);
                $message->bcc('soni@citis.kompasgramedia.com', 'Soni Rahayu');
                foreach($attachs as $file)
                {
                    $message->attach(storage_path("exports/" . $file . '.xlsx'));
                }
            });
        }
    }
}
