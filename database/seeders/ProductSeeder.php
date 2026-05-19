<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ukuran per kategori
        $sizes = [
            'taekwondo' => ['S', 'M', 'L', 'XL', 'XXL'],
            'karate'    => ['S', 'M', 'L', 'XL', 'XXL'],
            'silat'     => ['S', 'M', 'L', 'XL', 'XXL'],
            'boxing'    => ['8oz', '10oz', '12oz', '14oz', '16oz'],
            
        ];

        $data = [
            'taekwondo' => [
                ['name'=>'DOBOK POOMSAE PUGNATOR JUNIOR SENIOR TAEKWONDO','price'=>750000,'image'=>'taekwondo/product1.png','stock'=>50],
                ['name'=>'DOBOK TKS Taekwondo Kyurugi Olympic Series T-ONE','price'=>900000,'image'=>'taekwondo/product2.png','stock'=>30],
                ['name'=>'Dobok Star Olympic Pro Kuat Dan Nyaman','price'=>900000,'image'=>'taekwondo/product3.png','stock'=>25],
                ['name'=>'DOBOK TAEKWONDO MOOTO MTX BASIC S2 BK NECK','price'=>580000,'image'=>'taekwondo/product4.png','stock'=>40],
                ['name'=>'Dobok Pugnator Elite Champions Strips Blue Quick Dry','price'=>1150000,'image'=>'taekwondo/product5.png','stock'=>20],
                ['name'=>'Papan Demo Taekwondo Kayu Ringan 30x22,5 Cm','price'=>7999,'image'=>'taekwondo/product6.png','stock'=>100, 'sizes' => []],
                ['name'=>'Pelindung Kaki MTX ORIGINAL','price'=>280000,'image'=>'taekwondo/product7.png','stock'=>60],
            ],
            'karate' => [
                ['name'=>'Baju Karate Senkaido Untuk Pemula Anak s/d Dewasa','price'=>151000,'image'=>'karate/product1.png','stock'=>80],
                ['name'=>'SENKAIDO FACE MASK KARATE','price'=>208000,'image'=>'karate/product2.png','stock'=>45],
                ['name'=>'Senkaido Sabuk Karate Pemula Bahan Dril','price'=>17000,'image'=>'karate/product3.png','stock'=>200, 'sizes' => ['1 m', '1.5 m', '1.8 m', '2 m']],
                ['name'=>'SENKAIDO BODY PROTECTOR Model Kaos','price'=>194000,'image'=>'karate/product4.png','stock'=>35],
                ['name'=>'Muvon Body Protector Karate Expert Series','price'=>215000,'image'=>'karate/product5.png','stock'=>30],
                ['name'=>'SENKAIDO FOOT PROTECTOR','price'=>270000,'image'=>'karate/product6.png','stock'=>50],
                ['name'=>'Hand Protector Karate MUVON BASIC SERIES','price'=>110000,'image'=>'karate/product7.png','stock'=>70],
            ],
            'silat' => [
                ['name'=>'Seragam Siswa Pencak Silat Pagar Nusa Bahan Outdoor Kuat','price'=>105000,'image'=>'silat/product1.png','stock'=>60],
                ['name'=>'Sembong Silat Premium Seni Pencak Silat','price'=>120000,'image'=>'silat/product2.png','stock'=>40, 'sizes' => []],
                ['name'=>'Sembong Silat/dodot silat/kain samping','price'=>135000,'image'=>'silat/product3.png','stock'=>35, 'sizes' => []],
                ['name'=>'Sabuk Silat Official','price'=>25000,'image'=>'silat/product4.png','stock'=>150, 'sizes' => []],
                ['name'=>'SABUK PENCAK SILAT FULL KAIN POLOS LEBAR 5CM','price'=>10000,'image'=>'silat/product5.png','stock'=>200, 'sizes' => []],
                ['name'=>'Sembong Seni Pencak Silat Batik Katun All Size','price'=>120000,'image'=>'silat/product6.png','stock'=>45, 'sizes' => []],
                ['name'=>'Jilbab Krudung Instan Pencak Silat Premium Tebal','price'=>35000,'image'=>'silat/product7.png','stock'=>90, 'sizes' => []],
            ],
            'boxing' => [
                ['name'=>'WANNAFIT Helm Tinju Boxing Helmet','price'=>120000,'image'=>'boxing/product1.png','stock'=>55, 'sizes' => []],
                ['name'=>'WANNAFIT MAX Sarung Tinju 10oz 12oz Boxing Gloves','price'=>230000,'image'=>'boxing/product2.png','stock'=>40],
                ['name'=>'WANNAFIT Gum Shield Pelindung Mulut Boxing','price'=>15000,'image'=>'boxing/product3.png','stock'=>300, 'sizes' => ['Hitam', 'putih']],
                ['name'=>'WANNAFIT Paket Samsak Tinju Punching Bag','price'=>160000,'image'=>'boxing/product4.png','stock'=>25, 'sizes' => []],
                ['name'=>'WANNAFIT Handwrap 3 Meter & 5 Meter','price'=>50000,'image'=>'boxing/product5.png','stock'=>120, 'sizes' => []],
                ['name'=>'Sepatu Tinju Pria Boxing Shoes Sport','price'=>546000,'image'=>'boxing/product6.png','stock'=>20, 'sizes' => ['39', '40', '41', '42', '43', '44']],
                ['name'=>'Baju Tanding Tinju Setelan Boxing','price'=>180000,'image'=>'boxing/product7.png','stock'=>30],
            ],
        ];

        foreach ($data as $categorySlug => $products) {
            $category = Category::where('slug', $categorySlug)->first();
            if (!$category) continue;

            foreach ($products as $p) {
                // Kalau produk punya 'sizes' key sendiri, pakai itu. Kalau tidak ada key, pakai default kategori
                $productSizes = array_key_exists('sizes', $p) ? $p['sizes'] : $sizes[$categorySlug];

                Product::updateOrCreate(
                    ['slug' => Str::slug($p['name'])],
                    [
                        'category_id' => $category->id,
                        'name'        => $p['name'],
                        'slug'        => Str::slug($p['name']),
                        'price'       => $p['price'],
                        'stock'       => $p['stock'],
                        'image'       => $p['image'],
                        'sizes'       => $productSizes,
                        'status'      => 'active',
                        'sold'        => 0,
                    ]
                );
            }
        }
    }
}