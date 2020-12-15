<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::with('products')->orderByDesc('id')->get();
        return view('admin.categories.index',compact('categories'));
    }
    public function show(){
        $categories=Category::with('products')->orderByDesc('id')->get();
        return view('admin.categories.show',compact('categories'));
    }

    public function create(){
        return view('admin.categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'name'  =>'required|string|max:191|unique:categories,name',
        ]);
        $request->name=str_replace('/','-',$request->name);
        $category=Category::create($request->except('_token'));
        if ($category)
            success();
        else
            fail();

        return redirect()->route(auth()->user()->role === SELLER ?'category.show':'category.index');

    }

    public function edit($cat){
        // check if the category exist or not
        $category=Category::findOrFail($cat);
        /// category not founded
        if (!$category){
            fail("Not Found Plan ...");
            return redirect()->route('category.index');
        }
        return view('admin.categories.edit',compact('category'));
    }

    public function update(Request $request,$cat){
        // check if the category exist or not
        $category=Category::findOrFail($cat);
        /// category not founded
        if (!$category){
            fail("Not Found Plan ...");
            return redirect()->route('category.index');
        }
        $request->validate([
            'name'=>['required','string','max:191',Rule::unique('categories','name')->ignore($category->id)],
        ]);
        $request->name=str_replace('/','-',$request->name);
        if ($category->update($request->except(['_token','_method'])))
            success();
        else
            fail();
        return redirect()->route('category.index');
    }

    public function destroy($cat){
        // check if the category exist or not
        $category=Category::findOrFail($cat);
        /// category not founded
        if (!$category){
            fail("Not Found Plan ...");
            return redirect()->route('category.index');
        }
        //category founded and has products in it so that stop the operation
        if (count($category->products) > 0){
            fail("Can\' Remove This Category ...");
        }else{
            $category->delete();
            success();
        }

        return redirect()->route('category.index');
    }
}
