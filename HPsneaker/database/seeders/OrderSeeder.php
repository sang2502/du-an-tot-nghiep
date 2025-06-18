<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['completed', 'processing', 'cancelled'];
        $payments = ['COD', 'VNPAY', 'MOMO', 'PayPal'];

        // === CHỖ NÀY CẦN ĐÚNG ID của product_variants trong DB ===
        $product_variant_ids = DB::table('product_variants')->pluck('id')->toArray();

        // === VÒNG LẶP SEED 10 ĐƠN HÀNG ===
        for ($i = 1; $i <= 10; $i++) {

            // === CHỖ NÀY: CHẮC CHẮN ĐANG INSERT VÀO BẢNG 'orders' ===
            $order_id = DB::table('orders')->insertGetId([
                // === Các cột dưới đây phải KHỚP VỚI MIGRATION của bạn ===
                'user_id'           => rand(1, 2), // Đảm bảo có user_id 1 và 2 trong bảng users
                'total_amount'      => rand(100000, 500000),
                'voucher_id'        => rand(0, 1) ? 1 : null, // Chỉnh lại nếu không có voucher_id = 1
                'discount_applied'  => rand(1000, 30000),
                'status'            => $statuses[array_rand($statuses)],
                'payment_method'    => $payments[array_rand($payments)],
                'shipping_address'  => Str::random(10),
                'created_at'        => now()->subDays(rand(0, 30)),
                'updated_at'        => now(),
            ]);
            // === KẾT THÚC INSERT orders ===

            // === CHỖ NÀY: SEED 1-3 SẢN PHẨM CHO MỖI ĐƠN HÀNG ===
            $num_items = rand(1, 3);
            for ($j = 1; $j <= $num_items; $j++) {
                $variant_id = $product_variant_ids[array_rand($product_variant_ids)];
                $quantity = rand(1, 5);
                $price = rand(100000, 500000);

                // === ĐẢM BẢO ĐANG INSERT ĐÚNG TÊN BẢNG 'order_items' ===
                DB::table('order_items')->insert([
                    'order_id'           => $order_id, // KHÓA NGOẠI VÀO orders
                    'product_variant_id' => $variant_id,
                    'quantity'           => $quantity,
                    'price'              => $price,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);
            }
        }
    }
}
