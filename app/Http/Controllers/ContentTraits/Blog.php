<?php

namespace App\Http\Controllers\ContentTraits;

trait Blog
{
    public function blog_profile()
    {
        $viewVariables = [];

        return response()
            ->view('pages.content.blog.profile', $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.content.blog.profile.header'));
    }
}
