<?php

namespace App\Listeners;

use App\Events\ProductUpdateEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProductUpdateEvent  $event
     * @return void
     */
    public function handle(ProductUpdateEvent $event)
    {
        info('Update user listener after product Created... ' . $event->_product->name);
//            $userEditor = $this->_userRepo->getUsersByRole(RoleConstant::IS_EDITOR);
//            Notification::send($userEditor, new SentEmailToEditorNotification($newProduct));
    }
}
