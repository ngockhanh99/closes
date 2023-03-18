<?php

namespace App\Providers;

use App\Listeners\UploadListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ImageIsUploading::class => [
            UploadListener::class,
        ],
        ImageWasUploaded::class => [
            UploadListener::class,
        ],
        ImageIsDeleting::class => [
            UploadListener::class,
        ],
        ImageIsRenaming::class => [
            UploadListener::class,
        ],
        FolderIsRenaming::class => [
            UploadListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
