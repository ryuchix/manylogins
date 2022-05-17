<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\KeywordApi;

class SerpMasterKeyword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serpKeyword:master {limit}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SerpMaster Keywords API';

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
     * @return int
     */
    public function handle()
    {
        KeywordApi::serpKeywordsCommands($this->argument('limit'));
    }
}
