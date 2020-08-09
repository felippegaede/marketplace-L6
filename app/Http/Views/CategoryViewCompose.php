<?php

namespace App\Http\Views;

use App\Category;

class CategoryViewCompose
{
    public function compose($view){
        $categories = Category::all(['name', 'slug']);
        return $view->with('categories', $categories);
    }
}
