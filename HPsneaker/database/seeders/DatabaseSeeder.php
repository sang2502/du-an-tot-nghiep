<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'staff'],
            ['name' => 'customer'],
        ]);

        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'points' => 1000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
                'points' => 500,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        DB::table('categories')->insert([
            ['name' => 'Sneakers', 'slug' => 'sneakers', 'status' => true],
            ['name' => 'Boots', 'slug' => 'boots', 'status' => true],
        ]);

        DB::table('products')->insert([
            [
                'name' => 'Air Max 2025',
                'slug' => 'air-max-2025',
                'description' => 'A great new sneaker.',
                'category_id' => 1,
                'price' => 2500000,
                'thumbnail' => 'airmax2025.jpg',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        DB::table('sizes')->insert([
            ['label' => '39'],
            ['label' => '40'],
            ['label' => '41']
        ]);

        DB::table('colors')->insert([
            ['name' => 'Đỏ', 'hex_code' => '#FF0000'],
            ['name' => 'Trắng', 'hex_code' => '#FFFFFF']
        ]);

        DB::table('product_variants')->insert([
            [
                'product_id' => 1,
                'size_id' => 2, // 40
                'color_id' => 1, // Đỏ
                'stock' => 50,
                'price' => 2550000,
                'sku' => 'AM25-R40',
                'image' => 'am25_red_40.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        DB::table('vouchers')->insert([
            [
                'code' => 'SALE50',
                'description' => 'Giảm 50k cho đơn từ 500k',
                'discount_type' => 'fixed',
                'discount_value' => 50000,
                'max_discount' => 50000,
                'min_order_value' => 500000,
                'usage_limit' => 100,
                'used_count' => 0,
                'valid_from' => Carbon::now(),
                'valid_to' => Carbon::now()->addMonth(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);

        // Blog Category
        DB::table('blog_categories')->insert([
            [
                'id' => 1,
                'name' => 'Tin tức thời trang',
                'slug' => 'tin-tuc-thoi-trang'
            ]
        ]);

        // Blog Tags
        DB::table('blog_tags')->insert([
            [
                'id' => 1,
                'name' => 'Giày thể thao',
                'slug' => 'giay-the-thao'
            ],
            [
                'id' => 2,
                'name' => 'Phong cách',
                'slug' => 'phong-cach'
            ]
        ]);

        // Blog Post
        DB::table('blog_posts')->insert([
            [
                'id' => 1,
                'title' => 'Top 5 mẫu giày hot 2025',
                'slug' => 'top-5-mau-giay-hot-2025',
                'thumbnail' => 'https://example.com/thumb.jpg',
                'content' => '<p>Chi tiết bài viết...</p>',
                'status' => true,
                'published_at' => now(),
                'blog_category_id' => 1
            ]
        ]);

        // Blog Post - Tag (pivot table)
        DB::table('blog_post_tags')->insert([
            ['blog_post_id' => 1, 'blog_tag_id' => 1],
            ['blog_post_id' => 1, 'blog_tag_id' => 2],
        ]);
}
}