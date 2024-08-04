<?php

use App\Http\Controllers\Dashboard\AdminAuthenticationController;
use App\Http\Controllers\Dashboard\AttributeNameController;
use App\Http\Controllers\Dashboard\AttributeValueController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CouponConditionController;
use App\Http\Controllers\Dashboard\CouponController;
use App\Http\Controllers\Dashboard\CourierBranchController;
use App\Http\Controllers\Dashboard\CourierController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\DeliveryChargeSettingController;
use App\Http\Controllers\Dashboard\DeliveryManController;
use App\Http\Controllers\Dashboard\FaqController;
use App\Http\Controllers\Dashboard\FlashSaleController;
use App\Http\Controllers\Dashboard\LabelController;
use App\Http\Controllers\Dashboard\OrderStatusController;
use App\Http\Controllers\Dashboard\PosBranchController;
use App\Http\Controllers\Dashboard\PosCustomerController;
use App\Http\Controllers\Dashboard\PosOrderController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ProductRatingController;
use App\Http\Controllers\Dashboard\ProductReviewController;
use App\Http\Controllers\Dashboard\ReviewReplyController;
use App\Http\Controllers\Dashboard\ShippingAddressController;
use App\Http\Controllers\Dashboard\SizeGuidelineController;
use App\Http\Controllers\Dashboard\SizeGuidelineLabelController;
use App\Http\Controllers\Dashboard\SizeGuidelineValueController;
use App\Http\Controllers\Dashboard\SliderImageController;
use App\Http\Controllers\Dashboard\SliderSettingsController;
use App\Http\Controllers\Dashboard\SocialShopController;
use App\Http\Controllers\Dashboard\TagController;
use App\Models\DeliveryChargeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// api authentication routes

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');

    return "Cache cleared successfully";
});

Route::prefix('dashboard/v1')->group(
    function () {
        Route::post('register', [AdminAuthenticationController::class, 'userRegister']);
        Route::post('login', [AdminAuthenticationController::class, 'userLogin']);

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::post('logout', [AdminAuthenticationController::class, 'userLogout']);
            Route::get('user', [AdminAuthenticationController::class, 'userInfo']);
            Route::put('profile-update', [AdminAuthenticationController::class, 'userProfileUpdate']);

            // categories
            Route::apiResource('category', CategoryController::class);

            // labels
            Route::apiResource('label', LabelController::class);

            // tags
            Route::apiResource('tag', TagController::class);

            // brands
            Route::apiResource('brand', BrandController::class);

            // attribute name
            Route::apiResource('attribute-name', AttributeNameController::class);

            // attribute value
            Route::apiResource('attribute-value', AttributeValueController::class);

            // faq
            Route::apiResource('faq', FaqController::class);

            // product
            Route::apiResource('product', ProductController::class);
            Route::get('search-product', [ProductController::class, 'searchProduct']);

            // size guideline
            Route::apiResource('size-guideline', SizeGuidelineController::class);

            // size guideline label
            Route::apiResource('size-guideline-label', SizeGuidelineLabelController::class);

            // size guideline value
            Route::apiResource('size-guideline-value', SizeGuidelineValueController::class);

            // coupon condition
            Route::apiResource('coupon-condition', CouponConditionController::class);

            // coupon
            Route::apiResource('coupon', CouponController::class);

            // product review
            Route::apiResource('product-review', ProductReviewController::class);
            Route::put('product-review-status', [ProductReviewController::class, 'statusUpdate']);
            Route::get('product-review-reply/{id}', [ProductReviewController::class, 'productReviewReplies']);

            // review reply
            Route::apiResource('review-reply', ReviewReplyController::class);
            Route::put('review-reply-status', [ReviewReplyController::class, 'statusUpdate']);


            // product rating
            Route::apiResource('product-rating', ProductRatingController::class);
            Route::put('product-rating-status', [ProductRatingController::class, 'statusUpdate']);

            // flash sale
            Route::apiResource('flash-sale', FlashSaleController::class);

            // slider settings
            Route::get('slider-settings', [SliderSettingsController::class, 'index']);
            Route::post('slider-settings', [SliderSettingsController::class, 'update']);

            // slider image
            Route::apiResource('slider-image', SliderImageController::class);

            // order status
            Route::apiResource('order-status', OrderStatusController::class);

            // social shop
            Route::apiResource('social-shop', SocialShopController::class);

            // shipping address
            Route::apiResource('shipping-address', ShippingAddressController::class);

            // delivery man
            Route::apiResource('delivery-man', DeliveryManController::class);

            // courier
            Route::apiResource('courier', CourierController::class);

            // courier branch
            Route::apiResource('courier-branch', CourierBranchController::class);

            // pos branch
            Route::apiResource('pos-branch', PosBranchController::class);

            // customer
            Route::apiResource('customer', CustomerController::class);

            // pos customer
            Route::apiResource('pos-customer', PosCustomerController::class);
            Route::get('search-customer', [PosCustomerController::class, 'searchCustomer']);

            // pos order
            Route::apiResource('pos-order', PosOrderController::class);

            // delivery charge setting
            Route::apiResource('delivery-charge-setting', DeliveryChargeSettingController::class);
        });
    }
);
