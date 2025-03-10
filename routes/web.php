<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\SarprasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WakilRektorController;
use App\Http\Controllers\AkunController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/home', function () {
    if (Auth::user()->role_id == 1) {
        return redirect('admin/dashboard');
    } elseif (Auth::user()->role_id == 2) {
        return redirect('user/dashboard');
    } elseif (Auth::user()->role_id == 3) {
        return redirect('sarpras/dashboard');
    } elseif (Auth::user()->role_id == 4) {
        return redirect('perencanaan/dashboard');
    } elseif (Auth::user()->role_id == 5) {
        return redirect('pengadaan/dashboard');
    } else {
        return redirect('wakilRektor2/dashboard');
    }
});

//admin
Route::middleware(['auth', 'permission:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboardAdmin');
    Route::get('/admin/user', [AdminController::class, 'user'])->name('user');
    Route::get('/admin/deleteUser', [AdminController::class, 'destroy'])->name('destroyUser');
    Route::get('/admin/addUser', [AdminController::class, 'registerUser'])->name('addUser');
    Route::post('/registerUser', [AdminController::class, 'store'])->name('registerUser');
    Route::get('/admin/editUser/{id}', [AdminController::class, 'editUser'])->name('editUser');
    Route::put('/admin/update/{id}', [AdminController::class, 'updateUser'])->name('updateUser');
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('category');
    Route::get('/admin/item', [ItemController::class, 'admin'])->name('itemAdmin');
    Route::get('/admin/editProfile', [AuthController::class, 'editProfile'])->name('editProfileAdmin');
    Route::get('/admin/profile', [AuthController::class, 'profile'])->name('profileAdmin');
    Route::put('admin/editItem/{id}', [ItemController::class, 'editItem'])->name('editItem');
    Route::get('admin/purchaseRequest', [PurchaseRequestController::class, 'index'])->name('purchaseRequest');
    Route::get('/purchase-request', [PurchaseRequestController::class, 'showPurchaseRequestForm'])->name('purchaseRequestForm');
    Route::post('/purchase-request/add-detail', [PurchaseRequestController::class, 'addPurchaseRequest'])->name('addPurchaseRequest');
    Route::delete('/admin/deletePurchaseRequest/{id}', [PurchaseRequestController::class, 'deletePurchaseRequest'])->name('deletePurchaseRequestAdmin');
    Route::get('/admin/ajukanPP/{id}', [PurchaseRequestController::class, 'submitAjukan'])->name('ajukanPP');
    Route::get('/admin/tracking/{purchase_request_id}', [ApprovalController::class, 'tracking'])->name('trackingAdmin');
    Route::get('/admin/purchaseRequest/{id}', [PurchaseRequestController::class, 'formEdit'])->name('formEditPurchaseRequestAdmin');
    Route::put('/purchase-request/{id}', [PurchaseRequestController::class, 'update'])->name('purchaseRequest.update');
    Route::get('/purchase-request/{purchaseRequest}/delete-detail/{detail}', [PurchaseRequestController::class, 'deleteDetail'])->name('purchaseRequest.deleteDetail');
    Route::get('/admin/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::post('/admin/akun', [AkunController::class, 'create'])->name('akun.create');
    Route::get('/admin/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('/admin/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::delete('/admin/akun/{id}/delete', [AkunController::class, 'delete'])->name('akun.delete');
    Route::get('/admin/showPR/{id}', [PurchaseRequestController::class, 'showPR'])->name('showPR.admin');
    Route::get('/admin/detailUser/{id}', [AuthController::class, 'detailUser'])->name('detailUser.admin');
});


//user
Route::middleware(['auth', 'permission:2'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('dashboardUser');
    Route::get('/user/item', [ItemController::class, 'user'])->name('itemUser');
    Route::put('user/editItem/{id}', [ItemController::class, 'editItem'])->name('editItem');
    Route::get('/user/editProfile', [AuthController::class, 'editProfile'])->name('editProfileUser');
    Route::get('/user/profile', [AuthController::class, 'profile'])->name('profileUser');
    Route::get('/user/purchaseRequest', [PurchaseRequestController::class, 'index'])->name('PRUSer');
    Route::get('/user/akunAnggaran', [AkunController::class, 'index'])->name('akun.user');
    Route::get('/user/purchaseRequest/form', [PurchaseRequestController::class, 'showPurchaseRequestForm'])->name('formPR.user');
    Route::post('/user/addDPR', [PurchaseRequestController::class, 'addPurchaseRequest'])->name('addPurchaseRequest.user');
    Route::get('/user/showPR/{id}', [PurchaseRequestController::class, 'showPR'])->name('showPR.user');
    Route::get('/user/purchaseRequest/formEdit/{id}', [PurchaseRequestController::class, 'formEdit'])->name('formEditPurchaseRequest.user');
    Route::put('/user/purchase-request/{id}', [PurchaseRequestController::class, 'update'])->name('purchaseRequest.update.user');
    Route::get('/user/purchase-request/{purchaseRequest}/delete-detail/{detail}', [PurchaseRequestController::class, 'deleteDetail'])->name('purchaseRequest.deleteDetail.user');
    Route::delete('/user/deletePurchaseRequest/{id}', [PurchaseRequestController::class, 'deletePurchaseRequest'])->name('deletePurchaseRequest.user');
    Route::get('/user/ajukanPP/{id}', [PurchaseRequestController::class, 'submitAjukan'])->name('ajukanPP.user');
    Route::get('/user/tracking/{purchase_request_id}', [ApprovalController::class, 'tracking'])->name('tracking.user');
    Route::get('/user/category', [CategoryController::class, 'index'])->name('category.user');
    Route::post('/user/akun', [AkunController::class, 'create'])->name('akun.create.user');
    Route::get('/user/akun', [AkunController::class, 'index'])->name('akun.index.user');
    Route::put('/user/akun/{id}', [AkunController::class, 'update'])->name('akun.update.user');
    Route::delete('/user/akun/{id}/delete', [AkunController::class, 'delete'])->name('akun.delete.user');
});


//sarpras
Route::middleware(['auth', 'permission:3'])->group(function () {
    Route::get('/sarpras/dashboard', [SarprasController::class, 'index'])->name('dashboardSarpras');
    Route::get('/sarpras/item', [ItemController::class, 'sarpras'])->name('itemSarpras');
    Route::get('/sarpras/editProfile', [AuthController::class, 'editProfile'])->name('editProfileSarpras');
    Route::get('/sarpras/profile', [AuthController::class, 'profile'])->name('profileSarpras');
    Route::get('/sarpras/purchaseRequest', [PurchaseRequestController::class, 'index'])->name('PRsarpras');
    Route::get('/sarpras/approval/{id}', [ApprovalController::class, 'approve'])->name('approvesarpras');
    Route::get('/sarpras/reject/{id}', [ApprovalController::class, 'reject'])->name('rejectSarpras');
    Route::get('/sarpras/showPR/{id}', [PurchaseRequestController::class, 'showPR'])->name('showPR.sarpras');
});


//perencanaan
Route::middleware(['auth', 'permission:4'])->group(function () {
    Route::get('/perencanaan/dashboard', [PerencanaanController::class, 'index'])->name('dashboardPerencanaan');
    Route::get('/perencanaan/item', [ItemController::class, 'perencanaan'])->name('itemPerencanaan');
    Route::get('/perencanaan/editProfile', [AuthController::class, 'editProfile'])->name('editProfilePerencanaan');
    Route::get('/perencanaan/profile', [AuthController::class, 'profile'])->name('profilePerencanaan');
    Route::get('/perencanaan/purchaseRequest', [PurchaseRequestController::class, 'index'])->name('PRperencanaan');
    Route::get('/perencanaan/approval/{id}', [ApprovalController::class, 'approve'])->name('approveperencanaan');
    Route::get('/perencanaan/reject/{id}', [ApprovalController::class, 'reject'])->name('rejectPerencanaan');
    Route::get('/perencanaan/showPR/{id}', [PurchaseRequestController::class, 'showPR'])->name('showPR.perencanaan');
});


//pengadaan
Route::middleware(['auth', 'permission:5'])->group(function () {
    Route::get('/pengadaan/dashboard', [PengadaanController::class, 'index'])->name('dashboardPengadaan');
    Route::get('/pengadaan/item', [ItemController::class, 'pengadaan'])->name('itemPengadaan');
    Route::get('/pengadaan/editProfile', [AuthController::class, 'editProfile'])->name('editProfilePengadaan');
    Route::get('/pengadaan/profile', [AuthController::class, 'profile'])->name('profilePengadaan');
    Route::get('/pengadaan/purchaseRequest', [PurchaseRequestController::class, 'index'])->name('PRpengadaan');
    Route::get('/pengadaan/approval/{id}', [ApprovalController::class, 'approve'])->name('approvepengadaan');
    Route::get('/pengadaan/reject/{id}', [ApprovalController::class, 'reject'])->name('rejectPengadaan');
    Route::get('/pengadaan/showPR/{id}', [PurchaseRequestController::class, 'showPR'])->name('showPR.pengadaan');
    Route::get('/pengadaan/purchaseRequest/{id}', [PurchaseRequestController::class, 'formEdit'])->name('formEditPurchaseRequestPengadaan');
    Route::put('/user/purchase-request/{id}', [PurchaseRequestController::class, 'update'])->name('purchaseRequest.update.pengadaan');
});


//wakilrektor2
Route::middleware(['auth', 'permission:6'])->group(function () {
    Route::get('/wakilRektor2/dashboard', [WakilRektorController::class, 'index'])->name('dashboardWarek');
    Route::get('/wakilRektor2/item', [ItemController::class, 'warek'])->name('itemWarek');
    Route::get('/wakilRektor2/editProfile', [AuthController::class, 'editProfile'])->name('editProfileWarek');
    Route::get('/wakilRektor2/profile', [AuthController::class, 'profile'])->name('profileWarek');
    Route::get('/wakilRektor2/purchaseRequest', [PurchaseRequestController::class, 'index'])->name('PRwarek');
    Route::get('/wakilrektor2/approval/{id}', [ApprovalController::class, 'approve'])->name('approveWarek');
    Route::get('/wakilrektor2/reject/{id}', [ApprovalController::class, 'reject'])->name('rejectWarek');
    Route::get('/wakilrektor2/showPR/{id}', [PurchaseRequestController::class, 'showPR'])->name('showPR.warek');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/createItem', [ItemController::class, 'createItem'])->name('createItem');
    Route::post('/postItem', [ItemController::class, 'store'])->name('postItem');
    Route::delete('/deleteItem/{id}', [ItemController::class, 'destroy'])->name('destroyItem');
    Route::put('/updateProfile', [AuthController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/detailItem/{id}', [ItemController::class, 'detailItem'])->name('detailItem');
    Route::post('/category', [CategoryController::class, 'addCategory'])->name('addCategory');
    Route::get('/deleteCategory/{id}', [CategoryController::class, 'deleteCategory'])->name('deleteCategory');
    Route::put('/editCategory/{id}', [CategoryController::class, 'editCategory'])->name('editCategory');
});
