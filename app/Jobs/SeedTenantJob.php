<?php

namespace App\Jobs;

use App\Models\category;
use App\Models\{Tenant,User};
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SeedTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $tenant;
    public function __construct(Tenant $tenant)
    {
        $this->tenant= $tenant;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tenant->run(function(){
            User::create([
                'name'=>$this->tenant->name,
                'email'=>$this->tenant->email,
                'password'=>$this->tenant->password,
                
            ]);
            $user=User::latest()->first();
            $user->type='admin';
            $user->save();

            category::create([
                'category_name'=>'Electronics',
            ]);
        });
    }
}
