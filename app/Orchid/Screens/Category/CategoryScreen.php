<?php

namespace App\Orchid\Screens\Category;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;
use App\Models\Task; 
use Orchid\Screen\Action;
use Orchid\Screen\Modal;

use Orchid\Screen\TD;

use App\Models\Category;
use Illuminate\Http\Request;



class CategoryScreen extends Screen
{
    public $category = [
        'name' => '',
    ];

    public function query(): array
    {
        return [
            'categories' => Category::all(),
        ];
    }

    public function commandBar(): array
    {
        return [
            ModalToggle::make('Add Category')
                ->modal('categoryModal')
                ->method('createCategory')
                ->icon('plus'),
        ];
    }

public function layout(): array
{
    // return [
    //     Layout::modal('categoryModal', Layout::rows([
    //         Input::make('category.name')
    //             ->title('Category Name')
    //             ->placeholder('Enter category name')
    //             ->help('The name of the category to be created.'),
    //         Input::make('category.slug')
    //             ->title('Category Slug')
    //             ->placeholder('Enter category slug')
    //             ->help('The slug for the category.'),
    //     ]))
    //     ->title('Create Category')
    //     ->applyButton('Add Category'),
        
 

    // ];

    return[
        Layout::table('categories', [
            TD::make('name'),
            TD::make('slug'),
            TD::make('created_at')->sort(),
        ])

    ];
}




public function createCategory(Request $request)
{
    $request->validate([
        'category.name' => 'required|max:255|unique:categories,name',
        'category.slug' => 'required|alpha_dash|unique:categories,slug',
    ]);

    $category = new Category();
    $category->name = $request->input('category.name');
    $category->slug = $request->input('category.slug');
    $category->save();

    \Orchid\Support\Facades\Alert::info('Category created successfully.');

    // Reset the form fields by reinitializing them
    $this->category = [
        'name' => '',
        'slug' => '',
    ];
}


}
