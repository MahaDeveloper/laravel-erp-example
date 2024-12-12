<?php

namespace App\Modules\Client\Jobs;

use App\Modules\Client\Mail\ClientDetailMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendClientDetailEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $client;
    public $plainPassword;
    public $login_url;
    
    /**
     * Create a new job instance.
     *
     * @param $client
     * @param $password
     */
    public function __construct($client, $plainPassword, $login_url)
    {
        $this->client = $client;
        $this->plainPassword = $plainPassword;
        $this->login_url = $login_url;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->client->email)->send(new ClientDetailMail($this->client, $this->plainPassword, $this->login_url));
    }
}
