<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Page;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
     /**
     * Display all pages (main page page)
     */
    public function show($slug)
    {
        $locale = app()->getLocale();

        $page = Page::with(['translations' => function ($q) use ($locale) {
            $q->where('locale', $locale);
        }])->where('slug', $slug)
          ->where('status', 1)
          ->firstOrFail();

        $meta = (object)[
            'title' => $page->translate()->meta_title ?? $page->translate()->title,
            'description' => $page->translate()->meta_description ?? '',
            'keywords' => $page->translate()->meta_keywords ?? '',
        ];

        return view('pages.show', compact('page', 'meta'));
    }
    
}
