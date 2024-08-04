<?php

namespace App\Providers;

use App\Contracts\Dashboard\AttributeNameInterface;
use App\Contracts\Dashboard\AttributeValueInterface;
use App\Contracts\Dashboard\BrandInterface;
use App\Contracts\Dashboard\CategoryInterface;
use App\Contracts\Dashboard\CouponConditionInterface;
use App\Contracts\Dashboard\CouponInterface;
use App\Contracts\Dashboard\CourierBranchInterface;
use App\Contracts\Dashboard\CourierInterface;
use App\Contracts\Dashboard\CustomerInterface;
use App\Contracts\Dashboard\DeliveryChargeSettingInterface;
use App\Contracts\Dashboard\DeliveryManInterface;
use App\Contracts\Dashboard\FakeCounterInterface;
use App\Contracts\Dashboard\FaqInterface;
use App\Contracts\Dashboard\FlashSaleInterface;
use App\Contracts\Dashboard\FrequentlyBuyProductInterface;
use App\Contracts\Dashboard\LabelInterface;
use App\Contracts\Dashboard\OrderStatusInterface;
use App\Contracts\Dashboard\PosBranchInterface;
use App\Contracts\Dashboard\PosCustomerInterface;
use App\Contracts\Dashboard\PosOrderInterface;
use App\Contracts\Dashboard\ProductInterface;
use App\Contracts\Dashboard\ProductRatingInterface;
use App\Contracts\Dashboard\ProductReviewInterface;
use App\Contracts\Dashboard\ProductVariantInterface;
use App\Contracts\Dashboard\ReviewReplyInterface;
use App\Contracts\Dashboard\ShippingAddressInterface;
use App\Contracts\Dashboard\SizeGuidelineInterface;
use App\Contracts\Dashboard\SizeGuidelineLabelInterface;
use App\Contracts\Dashboard\SizeGuidelineValueInterface;
use App\Contracts\Dashboard\SliderImageInterface;
use App\Contracts\Dashboard\SliderSettingsInterface;
use App\Contracts\Dashboard\SocialShopInterface;
use App\Contracts\Dashboard\TagInterface;
use App\Contracts\Dashboard\UserAuthInterface;
use App\Repositories\Dashboard\AttributeNameRepository;
use App\Repositories\Dashboard\AttributeValueRepository;
use App\Repositories\Dashboard\BrandRepository;
use App\Repositories\Dashboard\CategoryRepository;
use App\Repositories\Dashboard\CouponConditionRepository;
use App\Repositories\Dashboard\CouponRepository;
use App\Repositories\Dashboard\CourierBranchRepository;
use App\Repositories\Dashboard\CourierRepository;
use App\Repositories\Dashboard\CustomerRepository;
use App\Repositories\Dashboard\DeliveryChargeSettingRepository;
use App\Repositories\Dashboard\DeliveryManRepository;
use App\Repositories\Dashboard\FakeCounterRepository;
use App\Repositories\Dashboard\FaqRepository;
use App\Repositories\Dashboard\FlashSaleRepository;
use App\Repositories\Dashboard\FrequentlyBuyProductRepository;
use App\Repositories\Dashboard\LabelRepository;
use App\Repositories\Dashboard\OrderStatusRepository;
use App\Repositories\Dashboard\PosBranchRepository;
use App\Repositories\Dashboard\PosCustomerRepository;
use App\Repositories\Dashboard\PosOrderRepository;
use App\Repositories\Dashboard\ProductRatingRepository;
use App\Repositories\Dashboard\ProductRepository;
use App\Repositories\Dashboard\ProductReviewRepository;
use App\Repositories\Dashboard\ProductVariantRepository;
use App\Repositories\Dashboard\ReviewReplyRepository;
use App\Repositories\Dashboard\ShippingAddressRepository;
use App\Repositories\Dashboard\SizeGuidelineLabelRepository;
use App\Repositories\Dashboard\SizeGuidelineRepository;
use App\Repositories\Dashboard\SizeGuidelineValueRepository;
use App\Repositories\Dashboard\SliderImageRepository;
use App\Repositories\Dashboard\SliderSettingsRepository;
use App\Repositories\Dashboard\SocialShopRepository;
use App\Repositories\Dashboard\TagRepository;
use App\Repositories\Dashboard\UserAuthRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserAuthInterface::class, UserAuthRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(LabelInterface::class, LabelRepository::class);
        $this->app->bind(TagInterface::class, TagRepository::class);
        $this->app->bind(BrandInterface::class, BrandRepository::class);
        $this->app->bind(AttributeNameInterface::class, AttributeNameRepository::class);
        $this->app->bind(AttributeValueInterface::class, AttributeValueRepository::class);
        $this->app->bind(FaqInterface::class, FaqRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(SizeGuidelineInterface::class, SizeGuidelineRepository::class);
        $this->app->bind(SizeGuidelineLabelInterface::class, SizeGuidelineLabelRepository::class);
        $this->app->bind(SizeGuidelineValueInterface::class, SizeGuidelineValueRepository::class);
        $this->app->bind(CouponConditionInterface::class, CouponConditionRepository::class);
        $this->app->bind(CouponInterface::class, CouponRepository::class);
        $this->app->bind(ProductReviewInterface::class, ProductReviewRepository::class);
        $this->app->bind(ProductRatingInterface::class, ProductRatingRepository::class);
        $this->app->bind(ReviewReplyInterface::class, ReviewReplyRepository::class);
        $this->app->bind(FlashSaleInterface::class, FlashSaleRepository::class);
        $this->app->bind(SliderSettingsInterface::class, SliderSettingsRepository::class);
        $this->app->bind(SliderImageInterface::class, SliderImageRepository::class);
        $this->app->bind(OrderStatusInterface::class, OrderStatusRepository::class);
        $this->app->bind(SocialShopInterface::class, SocialShopRepository::class);
        $this->app->bind(ShippingAddressInterface::class, ShippingAddressRepository::class);
        $this->app->bind(DeliveryManInterface::class, DeliveryManRepository::class);
        $this->app->bind(CourierInterface::class, CourierRepository::class);
        $this->app->bind(CourierBranchInterface::class, CourierBranchRepository::class);
        $this->app->bind(PosBranchInterface::class, PosBranchRepository::class);
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(PosCustomerInterface::class, PosCustomerRepository::class);
        $this->app->bind(PosOrderInterface::class, PosOrderRepository::class);
        $this->app->bind(DeliveryChargeSettingInterface::class, DeliveryChargeSettingRepository::class);
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
