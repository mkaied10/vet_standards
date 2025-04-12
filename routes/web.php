<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/specifications', [SpecificationController::class, 'specificationsIndex'])->name('specifications.index');
Route::get('/categories', [CategoryController::class, 'categoriesIndex'])->name('categories.index');
Route::get('/categories/{category}/subcategories', [SubcategoryController::class, 'subcategoriesIndex'])->name('subcategories.index');
Route::get('/subcategories/{subcategory}/specifications', [SpecificationController::class, 'subcategory'])->name('specifications.subcategory');
Route::get('/categories/{category}/specifications', [SpecificationController::class, 'category'])->name('specifications.category');
Route::get('/specifications/{specification}', [SpecificationController::class, 'show'])->name('specification.show');



Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('admin')->name('admin.')->prefix('admin')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('specifications', SpecificationController::class);
    Route::resource('users', UserController::class);
    // Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    // Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    // Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    // Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    // Route::get('/categories', [AdminController::class, 'indexCategories'])->name('admin.categories.index');
    // Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    // Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    // Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    // Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    // Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');

    // Route::get('/subcategories', [AdminController::class, 'indexSubcategories'])->name('admin.subcategories.index');
    // Route::get('/subcategories/create', [AdminController::class, 'createSubcategory'])->name('admin.subcategories.create');
    // Route::post('/subcategories', [AdminController::class, 'storeSubcategory'])->name('admin.subcategories.store');
    // Route::get('/subcategories/{subcategory}/edit', [AdminController::class, 'editSubcategory'])->name('admin.subcategories.edit');
    // Route::put('/subcategories/{subcategory}', [AdminController::class, 'updateSubcategory'])->name('admin.subcategories.update');
    // Route::delete('/subcategories/{subcategory}', [AdminController::class, 'destroySubcategory'])->name('admin.subcategories.destroy');
   
    // Route::get('/specifications', [AdminController::class, 'indexSpecifications'])->name('admin.specifications.index');
    // Route::get('/specifications/create', [AdminController::class, 'createSpecification'])->name('admin.specifications.create');
    // Route::post('/specifications', [AdminController::class, 'storeSpecification'])->name('admin.specifications.store');
    // Route::get('/specifications/{specification}/edit', [AdminController::class, 'editSpecification'])->name('admin.specifications.edit');
    // Route::put('/specifications/{specification}', [AdminController::class, 'updateSpecification'])->name('admin.specifications.update');
    // Route::delete('/specifications/{specification}', [AdminController::class, 'destroySpecification'])->name('admin.specifications.destroy');
});
Route::post('/admin/upload-image', function (Request $request) {
    if ($request->hasFile('upload')) {
        $path = $request->file('upload')->store('images', 'public');
        return response()->json([
            'uploaded' => true,
            'url' => asset('storage/' . $path)
        ]);
    }
    return response()->json(['uploaded' => false, 'error' => ['message' => 'No file uploaded']], 400);
})->middleware('admin');

// Route::prefix('admin')->middleware('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::resource('categories', CategoryController::class);
//     Route::resource('subcategories', SubcategoryController::class);
//     Route::resource('specifications', SpecificationController::class);
//     Route::resource('users', UserController::class);
// });
