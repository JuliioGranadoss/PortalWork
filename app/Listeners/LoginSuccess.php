<?php

namespace App\Listeners;

use Illuminate\Http\Request;
use App\Models\AccessLog;

class LoginSuccess
{
    protected $request;
    
    /**
     * Create the event listener.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  IlluminateAuthEventsLogin  $event
     * @return void
     */
    public function handle($event)
    {
        AccessLog::create([
            'user_id' => $event->user->id,
            'IP' => request()->ip(),
        ]);
    }
}
