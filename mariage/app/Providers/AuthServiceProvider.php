<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\Service;
use App\Policies\CommentPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Category;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    protected $policies = [
        Category::class => CategoryPolicy::class,
        Service::class => ServicePolicy::class,
        Comment::class => CommentPolicy::class,
    ];



    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Ajoute explicitement les gates ici, bien que cela ne soit pas toujours nécessaire avec le mapping automatique
        Gate::define('create-category', [CategoryPolicy::class, 'create']);
        Gate::define('update-category', [CategoryPolicy::class, 'update']);
        Gate::define('delete-category', [CategoryPolicy::class, 'delete']);

        // service


    }
}
