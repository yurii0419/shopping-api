<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,
            UserAddressSeeder::class,
            WebsiteGlobalSettingsSeeder::class,
            CategorySeeder::class,
            SubCategorySeeder::class,
            WomenSubsubCategorySeeder::class,
            MenSubsubCategorySeeder::class,
            KidsSubsubCategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class,
            SaleSeeder::class,
            StyleSeeder::class,
            SellerShopSeeder::class,
            // WishlistsSeeder::class,
            // ReviewsSeeder::class,
            LikesTableSeeder::class,
            // ConversationsTableSeeder::class,
            // MessagesTableSeeder::class,
            // ShopPerformanceSeeder::class,
        ]);
    }
}
