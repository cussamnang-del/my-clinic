<?php

use App\Http\Controllers\Admin\CompanyInformationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerHistory;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\DocumentLifeController;
use App\Http\Controllers\Admin\DocumentLifeDetailController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ItemGroupController;
use App\Http\Controllers\Admin\ItemTypeController;
use App\Http\Controllers\Admin\LifeSignController;
use App\Http\Controllers\Admin\OperativeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\Quality\EquipmentController;
use App\Http\Controllers\Admin\Quality\InternalAuditController;
use App\Http\Controllers\Admin\Quality\NonConformanceController;
use App\Http\Controllers\Admin\Quality\PendingResultsController;
use App\Http\Controllers\Admin\Quality\QcResultController;
use App\Http\Controllers\Admin\Quality\QualityDashboardController;
use App\Http\Controllers\Admin\Quality\ReagentLotController;
use App\Http\Controllers\Admin\Quality\RiskController;
use App\Http\Controllers\Admin\Quality\SopDocumentController;
use App\Http\Controllers\Admin\Quality\TatDashboardController;
use App\Http\Controllers\Admin\Quality\TrainingRecordController;
use App\Http\Controllers\Admin\ResultReleaseController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'throttle:admin', 'two-factor']], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('permissions/changeStatus', [PermissionController::class, 'changeStatus'])->name('permissions.changeStatus');
    Route::resource('permissions', PermissionController::class)->except('create', 'update');
    Route::get('roles/changeStatus', [RoleController::class, 'changeStatus'])->name('roles.changeStatus');
    Route::resource('roles', RoleController::class)->except('create', 'update');
    Route::get('users/changeStatus', [UserController::class, 'changeStatus'])->name('users.changeStatus');
    Route::resource('users', UserController::class)->except('create', 'update');
    Route::get('customers/changeStatus', [CustomerController::class, 'changeStatus'])->name('customers.changeStatus');
    Route::resource('customers', CustomerController::class)->except('create', 'update');
    Route::get('item_groups/changeStatus', [ItemGroupController::class, 'changeStatus'])->name('item_groups.changeStatus');
    Route::resource('item_groups', ItemGroupController::class)->except('create', 'update');
    Route::get('item_types/changeStatus', [ItemTypeController::class, 'changeStatus'])->name('item_types.changeStatus');
    Route::resource('item_types', ItemTypeController::class)->except('create', 'update');
    Route::get('items/changeStatus', [ItemController::class, 'changeStatus'])->name('items.changeStatus');
    Route::resource('items', ItemController::class)->except('create', 'update');
    Route::get('lifesigns/changeStatus', [LifeSignController::class, 'changeStatus'])->name('lifesigns.changeStatus');
    Route::resource('lifesigns', LifeSignController::class)->except('create', 'update');
    Route::controller(DocumentController::class)->group(function () {
        Route::get('documents/changeStatus', 'changeStatus')->name('documents.changeStatus');
        Route::get('documents/gotoService/document={document}/customer={customer}', 'gotoService')->name('documents.gotoService');
        Route::get('documents/getCustomer', 'getCustomer')->name('documents.getCustomer');
        Route::get('documents/getLifeSign', 'getLifeSign')->name('documents.getLifeSign');
        Route::get('documents/getBio', 'getBio')->name('documents.getBio');
        Route::get('documents/getGroupType', 'getGroupType')->name('documents.getGroupType');
        Route::get('documents/getItemTypeByName', 'getItemTypeByName')->name('documents.getItemTypeByName');
        Route::get('documents/getBioAnalystForm', 'getBioAnalystForm')->name('documents.getBioAnalystForm');
        Route::post('documents/storeBio', 'storeBio')->name('documents.storeBio');
        Route::get('documents/getPBio', 'getPBio')->name('documents.getPBio');
        Route::post('documents/storePBio', 'storePBio')->name('documents.storePBio');
        Route::post('documents/deletePBio', 'deletePBio')->name('documents.deletePBio');
        Route::get('documents/getMore', 'getMore')->name('documents.getMore');
        Route::post('documents/storeDoctorOrder', 'storeDoctorOrder')->name('documents.storeDoctorOrder');
        Route::post('documents/storeRx', 'storeRx')->name('documents.storeRx');
        Route::get('documents/getRx', 'getRx')->name('documents.getRx');
        Route::get('documents/editRxDetail', 'editRxDetail')->name('documents.editRxDetail');
        Route::post('documents/updateRxNurse', 'updateRxNurse')->name('documents.updateRxNurse');
        Route::get('documents/getRxDetail', 'getRxDetail')->name('documents.getRxDetail');
        Route::get('documents/showtRxDetail', 'showtRxDetail')->name('documents.showtRxDetail');
        Route::post('documents/deleteFile', 'deleteFile')->name('documents.deleteFile');
        Route::get('documents/pdfPreview/{id}', 'pdfPreview')->name('documents.pdfPreview');
        Route::get('documents/getNurseDetail', 'getNurseDetail')->name('documents.getNurseDetail');
        Route::post('documents/frmAddNewRxNurse', 'frmAddNewRxNurse')->name('documents.frmAddNewRxNurse');
        Route::get('documents/hospital/{customer}/{document}/show', 'showHospital')->name('documents.show.hospital');
        Route::get('documents/getObjectH', 'getObjectH')->name('documents.getObjectH');
        Route::post('documents/storeObjectH', 'storeObjectH')->name('documents.storeObjectH');
        Route::post('documents/storeObjectHT', 'storeObjectHT')->name('documents.storeObjectHT');
        Route::get('documents/editObjectHT', 'editObjectHT')->name('documents.editObjectHT');
        Route::post('documents/deleteObjectHT', 'deleteObjectHT')->name('documents.deleteObjectHT');
        Route::post('documents/deleteObjectHTD', 'deleteObjectHTD')->name('documents.deleteObjectHTD');
        Route::post('documents/storeObjectHNote', 'storeObjectHNote')->name('documents.storeObjectHNote');
        Route::get('documents/editObjectHNote', 'editObjectHNote')->name('documents.editObjectHNote');
        Route::post('documents/deleteObjectHNote', 'deleteObjectHNote')->name('documents.deleteObjectHNote');
        Route::post('documents/updateObjectHNote', 'updateObjectHNote')->name('documents.updateObjectHNote');
        Route::post('documents/storeDocumentLife', 'storeDocumentLife')->name('documents.documentlife.store');
        Route::post('documents/storeObjectOrder', 'storeObjectOrder')->name('documents.storeObjectOrder');
        Route::post('documents/storeObjectInjection', 'storeObjectInjection')->name('documents.storeObjectInjection');
        Route::get('documents/getObjectOrder', 'getObjectOrder')->name('documents.getObjectOrder');
        Route::get('documents/order/getProductByID', 'getProductByID')->name('documents.getProductByID');
        Route::get('documents/{order}/previewReceipt', 'previewReceipt')->name('documents.previewReceipt');
        Route::get('documents/search_how_to_use', 'search_how_to_use')->name('documents.search_how_to_use');
        Route::post('documents/checkout', 'checkout')->name('documents.checkout');
        Route::post('documents/customer/storeCustomer', 'storeCustomer')->name('documents.storeCustomer');
        Route::get('documents/doclife/editDocumentLife', 'editDocumentLife')->name('documents.editDocumentLife');
        Route::post('documents/updateDocumentLife', 'updateDocumentLife')->name('documents.updateDocumentLife');
        Route::get('documents/bioReceipt/Customer={customer_id}/Document={document_id}', 'bioReceipt')->name('documents.bio.receipt');
        Route::post('documents/filterTreatment', 'filterTreatment')->name('documents.filterTreatment');
        Route::get('documents/order/search_product', 'searchProduct')->name('documents.searchProduct');
        Route::post('documents/order/removeOrder', 'removeOrder')->name('documents.removeOrder');
        Route::post('documents/order/removeInjection', 'removeInjection')->name('documents.removeInjection');
    });
    Route::resource('documents', DocumentController::class)->except('create', 'update');
    Route::get('document_lives/changeStatus', [DocumentLifeController::class, 'changeStatus'])->name('document_lives.changeStatus');
    Route::resource('document_lives', DocumentLifeController::class)->except('create', 'update');
    Route::get('document_life_details/changeStatus', [DocumentLifeDetailController::class, 'changeStatus'])->name('document_life_detail.changeStatus');
    Route::resource('document_life_details', DocumentLifeDetailController::class)->except('create', 'update');
    Route::get('products/changeStatus', [ProductController::class, 'changeStatus'])->name('products.changeStatus');
    Route::post('products/storeOrder', [ProductController::class, 'store'])->name('products.storeNew');
    Route::resource('products', ProductController::class)->except('create', 'update');
    Route::get('rooms/changeStatus', [RoomController::class, 'changeStatus'])->name('rooms.changeStatus');
    Route::resource('rooms', RoomController::class)->except('create', 'update');
    Route::controller(CustomerHistory::class)->group(function () {
        Route::get('histories/showHistory', 'showHistory')->name('histories.showHistory');
        Route::get('histories/customer={customer}/detail', 'detail')->name('histories.detail');
        Route::get('histories/customerDetail', 'customerDetail')->name('histories.customerDetail');
        Route::get('histories/customer={customer}/document={document}/detail', 'documentDetail')->name('histories.documentDetail');
        Route::get('histories/order={order}/previewReceipt', 'previewReceipt')->name('histories.previewReceipt');
        Route::get('histories/showtRxDetail', 'showtRxDetail')->name('histories.showtRxDetail');
        Route::get('histories/Customer={customer}/serviceDetail', 'serviceDetail')->name('histories.serviceDetail');
        Route::get('histories/changeStatus', 'changeStatus')->name('histories.changeStatus');
        Route::get('customers/all/orders', 'order')->name('customers.order');
    });
    Route::controller(OperativeController::class)->group(function () {
        Route::get('documents/{OperativeProtocol}/receiptProtocol', 'receiptProtocol')->name('documents.receiptProtocol');
        Route::post('documents/storeProtocol', 'storeProtocol')->name('documents.storeProtocol');
        Route::get('documents/{MedicalCertificate}/receiptMedicine', 'receiptMedicine')->name('documents.receiptMedicine');
        Route::post('documents/storeMedicine', 'storeMedicine')->name('documents.storeMedicine');
    });

    Route::get('schedules/showCalendar', [ScheduleController::class, 'showCalendar'])->name('schedules.showCalendar');
    Route::get('schedules/showScheduleDocument/{schedule}', [ScheduleController::class, 'showScheduleDocument'])->name('schedules.showScheduleDocument');
    Route::get('schedules/detail/document/{document_id}/{customer_id}', [ScheduleController::class, 'showDetailByDocument'])->name('schedules.showDetailByDocument');

    Route::resource('schedules', ScheduleController::class);

    Route::get('company_informations/changeStatus', [CompanyInformationController::class, 'changeStatus'])->name('company_informations.changeStatus');
    Route::resource('company_informations', CompanyInformationController::class)->except('create', 'update');

    // Result-release workflow (Phase 2 — audit-ability foundation).
    // Each transition is rate-limited and requires the user's password as
    // an electronic signature (ISO 15189:2022 §7.3.7.4 / 21 CFR Part 11).
    Route::prefix('results')->name('results.')
        ->middleware('throttle:admin')
        ->controller(ResultReleaseController::class)
        ->group(function () {
            Route::post('{biodetail}/submit', 'submit')->name('submit');
            Route::post('{biodetail}/review', 'review')->name('review');
            Route::post('{biodetail}/release', 'release')->name('release');
            Route::post('{biodetail}/amend', 'amend')->name('amend');
        });

    /*
    |--------------------------------------------------------------------------
    | Quality dashboard & ISO module listings (Phase 5)
    |--------------------------------------------------------------------------
    |
    | Backends for these modules shipped in Phase 2 / Phase 3; Phase 5
    | wires read-only Blade UIs + the TAT / QC reporting surfaces.
    | Write operations are intentionally NOT exposed here yet — the
    | existing service layer (SopReleaseService, CapaWorkflowService,
    | RiskScoringService, ResultReleaseService) remains the only
    | mutator so workflow rules stay enforced.
    |
    */
    Route::prefix('quality')->name('quality.')->group(function () {
        Route::get('/', [QualityDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('sop', [SopDocumentController::class, 'index'])->name('sop.index');
        Route::get('sop/{sop}', [SopDocumentController::class, 'show'])->name('sop.show');

        Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment.index');
        Route::get('equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');

        Route::get('reagents', [ReagentLotController::class, 'index'])->name('reagents.index');

        Route::get('ncrs', [NonConformanceController::class, 'index'])->name('ncrs.index');
        Route::get('ncrs/{ncr}', [NonConformanceController::class, 'show'])->name('ncrs.show');

        Route::get('risks', [RiskController::class, 'index'])->name('risks.index');
        Route::get('risks/{risk}', [RiskController::class, 'show'])->name('risks.show');

        Route::get('internal-audits', [InternalAuditController::class, 'index'])->name('internal_audits.index');
        Route::get('internal-audits/{audit}', [InternalAuditController::class, 'show'])->name('internal_audits.show');

        Route::get('training', [TrainingRecordController::class, 'index'])->name('training.index');

        Route::get('tat', [TatDashboardController::class, 'index'])->name('tat.index');

        Route::get('qc', [QcResultController::class, 'index'])->name('qc.index');
        Route::get('qc/chart', [QcResultController::class, 'chart'])->name('qc.chart');

        Route::get('results', [PendingResultsController::class, 'index'])->name('results.index');
        Route::get('results/{biodetail}', [PendingResultsController::class, 'show'])->name('results.show');
    });
});
