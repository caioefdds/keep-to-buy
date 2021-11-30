<?php

use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Livewire\About;
use App\Http\Livewire\Accordion;
use App\Http\Livewire\Alerts;
use App\Http\Livewire\AvatarRadius;
use App\Http\Livewire\AvatarRound;
use App\Http\Livewire\Avatarsquare;
use App\Http\Livewire\Badge;
use App\Http\Livewire\Blog;
use App\Http\Livewire\Breadcrumbs;
use App\Http\Livewire\Buttons;
use App\Http\Livewire\Calendar;
use App\Http\Livewire\Calendar2;
use App\Http\Livewire\Cards;
use App\Http\Livewire\Carousel;
use App\Http\Livewire\Cart;
use App\Http\Livewire\Chart;
use App\Http\Livewire\ChartChartist;
use App\Http\Livewire\ChartDonut;
use App\Http\Livewire\ChartEchart;
use App\Http\Livewire\ChartFlot;
use App\Http\Livewire\ChartLine;
use App\Http\Livewire\ChartMorris;
use App\Http\Livewire\ChartNvd3;
use App\Http\Livewire\ChartPie;
use App\Http\Livewire\Charts;
use App\Http\Livewire\Chat;
use App\Http\Livewire\Checkout;
use App\Http\Livewire\Colors;
use App\Http\Livewire\Construction;
use App\Http\Livewire\Counters;
use App\Http\Livewire\CryptoCurrencies;
use App\Http\Livewire\Datatable;
use App\Http\Livewire\Dropdown;
use App\Http\Livewire\Editprofile;
use App\Http\Livewire\Email;
use App\Http\Livewire\Emailservices;
use App\Http\Livewire\Emptypage;
use App\Http\Livewire\Error400;
use App\Http\Livewire\Error401;
use App\Http\Livewire\Error403;
use App\Http\Livewire\Error404;
use App\Http\Livewire\Error500;
use App\Http\Livewire\Error503;
use App\Http\Livewire\Faq;
use App\Http\Livewire\Footers;
use App\Http\Livewire\ForgotPassword;
use App\Http\Livewire\FormAdvanced;
use App\Http\Livewire\FormElements;
use App\Http\Livewire\FormValidation;
use App\Http\Livewire\FormWizard;
use App\Http\Livewire\Gallery;
use App\Http\Livewire\Headers;
use App\Http\Livewire\Icons;
use App\Http\Livewire\Icons10;
use App\Http\Livewire\Icons2;
use App\Http\Livewire\Icons3;
use App\Http\Livewire\Icons4;
use App\Http\Livewire\Icons5;
use App\Http\Livewire\Icons6;
use App\Http\Livewire\Icons7;
use App\Http\Livewire\Icons8;
use App\Http\Livewire\Icons9;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Index;
use App\Http\Livewire\Invoice;
use App\Http\Livewire\Listpage;
use App\Http\Livewire\Loaders;
use App\Http\Livewire\Lockscreen;
use App\Http\Livewire\Login;
use App\Http\Livewire\Maps;
use App\Http\Livewire\Maps1;
use App\Http\Livewire\Maps2;
use App\Http\Livewire\Mediaobject;
use App\Http\Livewire\Modal;
use App\Http\Livewire\Navigation;
use App\Http\Livewire\Notify;
use App\Http\Livewire\Pagination;
use App\Http\Livewire\Panels;
use App\Http\Livewire\Pricing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Progress;
use App\Http\Livewire\Rangeslider;
use App\Http\Livewire\Rating;
use App\Http\Livewire\Register;
use App\Http\Livewire\Scroll;
use App\Http\Livewire\Search;
use App\Http\Livewire\Services;
use App\Http\Livewire\Shop;
use App\Http\Livewire\ShopDescription;
use App\Http\Livewire\Sweetalert;
use App\Http\Livewire\Tables;
use App\Http\Livewire\Tabs;
use App\Http\Livewire\Tags;
use App\Http\Livewire\Terms;
use App\Http\Livewire\Thumbnails;
use App\Http\Livewire\Timeline;
use App\Http\Livewire\Tooltipandpopover;
use App\Http\Livewire\Treeview;
use App\Http\Livewire\Typography;
use App\Http\Livewire\UsersList;
use App\Http\Livewire\Widgets;
use App\Http\Livewire\Wishlist;
use App\Http\Livewire\Wysiwyag;
use App\Http\Controllers\Admin\ProfitsController;
use App\Http\Controllers\Admin\ExpensesController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\InvoiceItemsController;
use App\Http\Controllers\Admin\ProfitRecordItemsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Dotenv\Loader\Loader;
use Faker\Provider\ar_SA\Color;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/logout', [LoginController::class, 'logout']);

/* Register Routes */
Route::prefix('register')->group(function () {
    Route::get('/', Register::class)->name('register');
    Route::post('/', [RegisterController::class, 'register']);
});

/* Login Routes */
Route::prefix('login')->group(function () {
    Route::get('/', Login::class)->name('login');
    Route::post('/', [LoginController::class, 'authenticate']);
});

Route::get('/', function () {
    return view('livewire.index');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [InvoicesController::class, 'index']);
    Route::get('index', [InvoicesController::class, 'index']);

    Route::prefix('invoices')->group(function () {
        Route::post('/get', [InvoicesController::class, 'get']);
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index']);
        Route::get('/get/{id}', [ProfileController::class, 'get']);
        Route::post('/update', [ProfileController::class, 'update']);
    });

    Route::prefix('invoice_items')->group(function () {
        Route::post('/pay', [InvoiceItemsController::class, 'pay']);
        Route::post('/refund', [InvoiceItemsController::class, 'refund']);
        Route::post('/editRegistry', [InvoiceItemsController::class, 'editRegistry']);
        Route::post('/deleteRegistry', [InvoiceItemsController::class, 'deleteRegistry']);
    });

    Route::prefix('profit_records')->group(function () {
        Route::post('/receive', [ProfitRecordItemsController::class, 'receive']);
        Route::post('/refund', [ProfitRecordItemsController::class, 'refund']);
        Route::post('/editRegistry', [ProfitRecordItemsController::class, 'editRegistry']);
        Route::post('/deleteRegistry', [ProfitRecordItemsController::class, 'deleteRegistry']);
    });

    Route::prefix('profits')->group(function () {
        Route::get('/', [ProfitsController::class, 'index']);
        Route::get('/get    ', [ProfitsController::class, 'get']);
        Route::get('/getAll', [ProfitsController::class, 'getAll']);
        Route::get('/create', [ProfitsController::class, 'createPage']);
        Route::post('/create', [ProfitsController::class, 'create']);
        Route::get('/edit/{id}', [ProfitsController::class, 'edit']);
        Route::post('/update', [ProfitsController::class, 'update']);
        Route::delete('/delete', [ProfitsController::class, 'delete']);
    });

    Route::prefix('expenses')->group(function () {
        Route::get('/', [ExpensesController::class, 'index']);
        Route::get('/get    ', [ExpensesController::class, 'get']);
        Route::get('/getAll', [ExpensesController::class, 'getAll']);
        Route::get('/create', [ExpensesController::class, 'createPage']);
        Route::post('/create', [ExpensesController::class, 'create']);
        Route::get('/edit/{id}', [ExpensesController::class, 'edit']);
        Route::post('/update', [ExpensesController::class, 'update']);
        Route::post('/delete', [ExpensesController::class, 'delete']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/get    ', [CategoryController::class, 'get']);
        Route::get('/getAll', [CategoryController::class, 'getAll']);
        Route::get('/create', [CategoryController::class, 'createPage']);
        Route::post('/create', [CategoryController::class, 'create']);
        Route::get('/edit/:id', [CategoryController::class, 'edit']);
        Route::post('/update', [CategoryController::class, 'update']);
        Route::post('/delete', [CategoryController::class, 'delete']);
    });

    Route::prefix('groups')->group(function () {
        Route::get('/', [GroupController::class, 'index']);
        Route::get('/get    ', [GroupController::class, 'get']);
        Route::get('/getAll', [GroupController::class, 'getAll']);
        Route::get('/create', [GroupController::class, 'createPage']);
        Route::post('/create', [GroupController::class, 'create']);
        Route::get('/edit/:id', [GroupController::class, 'edit']);
        Route::post('/update', [GroupController::class, 'update']);
        Route::post('/delete', [GroupController::class, 'delete']);
    });
});
Route::get('about', About::class);
Route::get('accordion', Accordion::class);
Route::get('alerts', Alerts::class);
Route::get('avatar-radius', AvatarRadius::class);
Route::get('avatar-round', AvatarRound::class);
Route::get('avatarsquare', Avatarsquare::class);
Route::get('badge', Badge::class);
Route::get('blog', Blog::class);
Route::get('breadcrumbs', Breadcrumbs::class);
Route::get('buttons', Buttons::class);
Route::get('calendar', Calendar::class);
Route::get('calendar2', Calendar2::class);
Route::get('cards', Cards::class);
Route::get('carousel', Carousel::class);
Route::get('cart', Cart::class);
Route::get('chart-chartist', ChartChartist::class);
Route::get('chart-donut', ChartDonut::class);
Route::get('chart-echart', ChartEchart::class);
Route::get('chart-flot', ChartFlot::class);
Route::get('chart-line', ChartLine::class);
Route::get('chart-morris', ChartMorris::class);
Route::get('chart-nvd3', ChartNvd3::class);
Route::get('chart-pie', ChartPie::class);
Route::get('chart', Chart::class);
Route::get('charts', Charts::class);
Route::get('chat', Chat::class);
Route::get('checkout', Checkout::class);
Route::get('colors', Colors::class);
Route::get('construction', Construction::class);
Route::get('counters', Counters::class);
Route::get('crypto-currencies', CryptoCurrencies::class);
Route::get('datatable', Datatable::class);
Route::get('dropdown', Dropdown::class);
Route::get('editprofile', Editprofile::class);
Route::get('email', Email::class);
Route::get('emailservices', Emailservices::class);
Route::get('emptypage', Emptypage::class);
Route::get('error400', Error400::class);
Route::get('error401', Error401::class );
Route::get('error403', Error403::class );
Route::get('error404', Error404::class );
Route::get('error500', Error500::class );
Route::get('error503', Error503::class );
Route::get('faq', Faq::class);
Route::get('footers', Footers::class);
Route::get('forgot-password', ForgotPassword::class);
Route::get('form-advanced', FormAdvanced::class);
Route::get('form-elements', FormElements::class);
Route::get('form-validation', FormValidation::class);
Route::get('form-wizard', FormWizard::class);
Route::get('gallery', Gallery::class);
Route::get('headers', Headers::class);
Route::get('icons', Icons::class);
Route::get('icons2', Icons2::class);
Route::get('icons3', Icons3::class);
Route::get('icons4', Icons4::class);
Route::get('icons5', Icons5::class);
Route::get('icons6', Icons6::class);
Route::get('icons7', Icons7::class);
Route::get('icons8', Icons8::class);
Route::get('icons9', Icons9::class);
Route::get('icons10', Icons10::class);
Route::get('invoice', Invoice::class);
Route::get('listpage', Listpage::class);
Route::get('loaders', Loaders::class);
Route::get('lockscreen', Lockscreen::class);
Route::get('maps', Maps::class);
Route::get('maps1', Maps1::class);
Route::get('maps2', Maps2::class);
Route::get('mediaobject', Mediaobject::class);
Route::get('modal', Modal::class);
Route::get('navigation', Navigation::class);
Route::get('notify', Notify::class);
Route::get('pagination', Pagination::class);
Route::get('panels', Panels::class);
Route::get('pricing', Pricing::class);
Route::get('progress', Progress::class);
Route::get('rangeslider', Rangeslider::class);
Route::get('rating', Rating::class);
Route::get('scroll', Scroll::class);
Route::get('search', Search::class);
Route::get('services', Services::class);
Route::get('shop-description', ShopDescription::class);
Route::get('shop', Shop::class);
Route::get('sweetalert', Sweetalert::class);
Route::get('tables', Tables::class);
Route::get('tabs', Tabs::class);
Route::get('tags', Tags::class);
Route::get('terms', Terms::class);
Route::get('thumbnails', Thumbnails::class);
Route::get('timeline', Timeline::class);
Route::get('tooltipandpopover', Tooltipandpopover::class);
Route::get('treeview', Treeview::class);
Route::get('typography', Typography::class);
Route::get('users-list', UsersList::class);
Route::get('widgets', Widgets::class);
Route::get('wishlist', Wishlist::class);
Route::get('wysiwyag', Wysiwyag::class);

