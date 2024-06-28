<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Blog;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('own-blog', function (User $user, Blog $blog) {
            return $user->id === $blog->user_id;
        });
    }
}
