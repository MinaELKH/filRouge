<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

//class CategoryController extends Controller
//{
//    /**
//     * Display a listing of the resource.
//     */
//    protected  $categoryService ;
//    public function __construct(CategoryService  $categoryService){
//       $this->categoryService = $categoryService;
//    }
//    public function index()
//    {
//         $categories = $this->categoryService->getAll();
//        // return view('category.index',compact('categories'));
//        return response()->json($categories);
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     */
//    public function create(Request $request )
//    {
//
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(Request $request)
//    {
//       // dd(auth()->user());
//       $this->authorize('create', Category::class);
//        $validated = $request->validate([
//            'name' => 'required|string|unique:categories',
//            'description'=>'nullable|string',
//        ]) ;
//        return $this->categoryService->store($request);
//    }
//
//    /**
//     * Display the specified resource.
//     */
//    public function show(category $category)
//    {
//        return $this->categoryService->show($category);
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     */
////    public function edit(category $category)
////    {
////        $category = $this->categoryService->edit($category);
////    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(Request $request, category $category)
//    {
//        $this->authorize('update', Category::class);
//        $validated = $request->validate([
//            'name' => 'required|string',
//            'description'=>'nullable|string',
//        ]) ;
//        return $this->categoryService->update($request,$category);
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(category $category)
//    {
//        $this->authorize('delete', Category::class);
//        return $this->categoryService->destroy($category);
//    }
//}
//




class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getAll();
     //   dd(auth()->user()->role);
        return view('admin.manage_categorie', compact('categories'));
    }

    public function store(Request $request)
    {
        // Valider les données
        $request->validate([
            'name' => 'required|string|unique:categories',
            'description' => 'nullable|string',
        ]);

        // Créer la nouvelle catégorie
        $category = Category::create($request->only(['name', 'description']));

        // Rediriger avec un message de succès
        return redirect()->route('admin.manage_categorie')->with('success', 'Catégorie ajoutée avec succès');
    }

    public function update(Request $request, category $category)
    {
        $this->authorize('delete', $category);
        $validated = $request->validate([
            'name' => 'required|string',
            'description'=>'nullable|string',
        ]) ;
        return redirect()->route('admin.manage_categorie')->with('success', 'Catégorie modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        $this->authorize('delete', $category);
        $this->categoryService->destroy($category);
        // Rediriger avec un message de succès
        return redirect()->route('admin.manage_categorie')->with('success', 'Catégorie supprimé avec succès');

    } }
