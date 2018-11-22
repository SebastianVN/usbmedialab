<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        ##Admin42
        View::composer(
            ['layouts.admin.master_nav_side', 'layouts.admin.master_nav_side', 'admin.dashboard'],
            'App\Http\ViewComposers\AdminComposer'
        );

        View::composer(
            ['layouts.admin.master_nav_side', 'layouts.admin.master_nav_up', 'layouts.admin.master_nav_side', 'admin.dashboard', 'admin.users', 'admin.user'],
            'App\Http\ViewComposers\AdminComposer'
        );


        ##Blog
        View::composer(
            ['layouts.blog.master', 'blog.main', 'blog.category', 'blog.post', 'blog.blogger', 'blog.tag', 'admin.blog_info'],
            'App\Http\ViewComposers\BlogComposer'
        );

        ##BlogMan
        View::composer(
            ['admin.blog_post_editor'],
            'App\Http\ViewComposers\BlogImagesComposer'
        );


        #Secciones de Contenido
        #require_once('/home/'.env("APP_USER", 'app').'/app/app/Http/ViewComposers/42AppComposerLink.php');
        View::composer('site.index', 'App\Http\ViewComposers\LandingComposer');
        View::composer('site.gallery', 'App\Http\ViewComposers\GalleryComposer');
        View::composer(
            ['site.about'],
            'App\Http\ViewComposers\AboutComposer'
        );
        View::composer(
            ['site.our_programs'],
            'App\Http\ViewComposers\EducationModelComposer'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
