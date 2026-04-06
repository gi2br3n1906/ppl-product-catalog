<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Alat Tulis (5)
            ['name' => 'Buku Tulis Sinar Dunia 58 Lembar (Pack)', 'description' => 'Buku tulis bergaris Sinar Dunia isi 58 lembar per buku. Satu pack isi 10 buku, cocok untuk sekolah dan kantor.', 'price' => 38000, 'stock' => 120, 'category' => 'Alat Tulis', 'image_kw' => 'notebook'],
            ['name' => 'Pulpen Gel Kenko Easy Gel 0.5 Hitam', 'description' => 'Pulpen gel Kenko dengan tinta hitam pekat, ketebalan 0.5mm yang nyaman digunakan untuk menulis cepat.', 'price' => 3500, 'stock' => 300, 'category' => 'Alat Tulis', 'image_kw' => 'pen,black'],
            ['name' => 'Pensil Faber-Castell 2B (Pack 12)', 'description' => 'Pensil 2B asli Faber-Castell yang dirancang untuk ujian komputer dan menggambar. Kayu empuk dan mudah diserut.', 'price' => 45000, 'stock' => 80, 'category' => 'Alat Tulis', 'image_kw' => 'pencil'],
            ['name' => 'Spidol Stabilo Boss Original Kuning', 'description' => 'Highlighter Stabilo Boss warna kuning neon, tahan kering hingga 4 jam walaupun tutup terbuka.', 'price' => 15000, 'stock' => 150, 'category' => 'Alat Tulis', 'image_kw' => 'highlighter'],
            ['name' => 'Kertas HVS A4 80gsm PaperOne', 'description' => 'Kertas print dan fotokopi PaperOne ukuran A4 (210x297 mm) dengan ketebalan 80 gsm. Isi 500 lembar.', 'price' => 52000, 'stock' => 200, 'category' => 'Alat Tulis', 'image_kw' => 'paper'],

            // Fashion (5)
            ['name' => 'Kemeja Flannel Pria Lengan Panjang Hitam', 'description' => 'Kemeja pria motif kotak-kotak bahan flannel premium yang tebal dengan cutting reguler fit.', 'price' => 125000, 'stock' => 45, 'category' => 'Fashion', 'image_kw' => 'flannel,shirt'],
            ['name' => 'Sepatu Sneakers Canvas Vans Old Skool', 'description' => 'Sepatu kasual ikonik Vans Old Skool warna hitam putih. Cocok untuk daily wear pria dan wanita.', 'price' => 899000, 'stock' => 30, 'category' => 'Fashion', 'image_kw' => 'vans,shoes'],
            ['name' => 'Celana Jeans Denim Levis 501', 'description' => 'Jeans original Levis 501 pria, potongan straight leg classic dengan kancing.', 'price' => 750000, 'stock' => 25, 'category' => 'Fashion', 'image_kw' => 'jeans,denim'],
            ['name' => 'Tas Ransel Eiger Laptop Backpack 25L', 'description' => 'Tas punggung pria Eiger kapasitas 25 liter dengan kompartemen khusus laptop 14 inci dan jas hujan tas (rain cover).', 'price' => 425000, 'stock' => 40, 'category' => 'Fashion', 'image_kw' => 'backpack,bag'],
            ['name' => 'Jam Tangan Casio G-Shock G-5600', 'description' => 'Jam tangan pria desain tangguh anti benturan, tahan air hingga 200 meter, dilengkapi stopwatch dan alarm.', 'price' => 1200000, 'stock' => 15, 'category' => 'Fashion', 'image_kw' => 'watch,gshock'],

            // Elektronik (5)
            ['name' => 'Apple iPhone 15 Pro Max 256GB Titanium', 'description' => 'Smartphone Apple terbaru dengan chipset A17 Pro, layar Super Retina XDR 6.7 inci, dan kamera utama 48MP.', 'price' => 24500000, 'stock' => 10, 'category' => 'Elektronik', 'image_kw' => 'iphone,smartphone'],
            ['name' => 'Laptop Asus ROG Zephyrus G14 OLED', 'description' => 'Laptop gaming asus layar OLED 14 inci dengan 120Hz, prosesor AMD Ryzen 9 8945HS, dan RTX 4060. Body ultra-ringan.', 'price' => 29000000, 'stock' => 8, 'category' => 'Elektronik', 'image_kw' => 'laptop,gaming'],
            ['name' => 'Smart TV Samsung 43 inch 4K UHD', 'description' => 'Televisi pintar Samsung dengan resolusi 4K UHD, didukung Tizen OS, Netflix, Youtube, dan layar jernih Crystal Processor.', 'price' => 4100000, 'stock' => 20, 'category' => 'Elektronik', 'image_kw' => 'tv,television'],
            ['name' => 'Sony Headphone Bluetooth WH-1000XM5', 'description' => 'Headphone nirkabel Sony unggulan dengan fitur noise cancelling terbaik (ANC), kualitas suara Hi-Res dan baterai 30 jam.', 'price' => 4999000, 'stock' => 12, 'category' => 'Elektronik', 'image_kw' => 'headphone,sony'],
            ['name' => 'Kulkas LG 2 Pintu Inverter 225L', 'description' => 'Kulkas 2 pintu hemat energi dengan teknologi Smart Inverter Compressor. Terdapat fitur no-frost dan multi air flow.', 'price' => 3800000, 'stock' => 14, 'category' => 'Elektronik', 'image_kw' => 'refrigerator'],

            // Furnitur (5)
            ['name' => 'Kursi Kerja Ergonomis Jaring Hitam', 'description' => 'Kursi kantor hidrolik dengan sandaran jaring (mesh) yang bernafas, nyaman untuk bekerja seharian.', 'price' => 550000, 'stock' => 35, 'category' => 'Furnitur', 'image_kw' => 'office,chair'],
            ['name' => 'Meja Belajar Minimalis Kayu Jati', 'description' => 'Meja kerja/belajar estetik bergaya Skandinavia ukuran 100x50 cm, material kayu pinus dengan dua laci laci terbuka.', 'price' => 850000, 'stock' => 18, 'category' => 'Furnitur', 'image_kw' => 'desk,table'],
            ['name' => 'Lemari Pakaian 3 Pintu Cermin', 'description' => 'Lemari baju berbahan partikel board ukuran besar 120x40x180 cm dengan cermin full body ditengah.', 'price' => 1100000, 'stock' => 10, 'category' => 'Furnitur', 'image_kw' => 'wardrobe,cabinet'],
            ['name' => 'Sofa Bed Minimalis Kain Fabric', 'description' => 'Sofa ruang tamu tipe scandinavian yang bisa direbahkan menjadi tempat tidur, material kain fabric lembut empuk.', 'price' => 1550000, 'stock' => 20, 'category' => 'Furnitur', 'image_kw' => 'sofa'],
            ['name' => 'Rak Buku Susun Kayu 4 Tingkat', 'description' => 'Rak display serbaguna desain terbuka dengan 4 ambalan bernuansa kayu oak untuk buku atau pajangan minimalis.', 'price' => 299000, 'stock' => 50, 'category' => 'Furnitur', 'image_kw' => 'bookshelf,shelf'],

            // Olahraga (5)
            ['name' => 'Sepatu Lari Adidas Running Duramo', 'description' => 'Sepatu lari pria Adidas Duramo dengan bantalan lightmotion yang enteng dan sol karet kokoh.', 'price' => 850000, 'stock' => 22, 'category' => 'Olahraga', 'image_kw' => 'running,shoes'],
            ['name' => 'Matras Yoga Mat NBR 8mm Anti Slip', 'description' => 'Alas senam/yoga ketebalan 8 milimeter bahan NBR lembut tidak licin. Free tas jaring.', 'price' => 95000, 'stock' => 100, 'category' => 'Olahraga', 'image_kw' => 'yoga,mat'],
            ['name' => 'Raket Badminton Yonex Arcsaber', 'description' => 'Raket bulutangkis original Yonex tipe Arcsaber lentur seimbang. Plus senar terpasang dan grip handuk.', 'price' => 550000, 'stock' => 30, 'category' => 'Olahraga', 'image_kw' => 'badminton,racket'],
            ['name' => 'Dumbbell Barbel Neoprene 5 Kg', 'description' => 'Sepasang barbel dumbel hexagon dengan lapisan karet neoprene warna warni, beban 5 kilo per pcs.', 'price' => 180000, 'stock' => 45, 'category' => 'Olahraga', 'image_kw' => 'dumbbell,fitness'],
            ['name' => 'Bola Basket Molten BG3800 Size 7', 'description' => 'Bola basket komposit kulit sitetis desain original FIBA size 7 (dewasa) yang awet untuk bermain indoor dan outdoor.', 'price' => 420000, 'stock' => 25, 'category' => 'Olahraga', 'image_kw' => 'basketball'],

            // Makanan (5)
            ['name' => 'Indomie Mi Goreng Spesial (Karton isi 40)', 'description' => 'Mie instan kebanggaan Indonesia dengan bumbu goreng khasnya, satu dus box berisi 40 bungkus.', 'price' => 110000, 'stock' => 500, 'category' => 'Makanan', 'image_kw' => 'noodles'],
            ['name' => 'Kopi Bubuk Kapal Api Special Mix 160g', 'description' => 'Kopi hitam serbuk giling siap seduh, perpaduan biji kopi pilihan dengan ciri khas wangi pekat Kapal Api.', 'price' => 14000, 'stock' => 300, 'category' => 'Makanan', 'image_kw' => 'coffee,powder'],
            ['name' => 'Susu Bear Brand Steril 189ml', 'description' => 'Susu murni sapi steril dalam kaleng khas beruang, dikonsumsi menyehatkan tubuh.', 'price' => 10000, 'stock' => 400, 'category' => 'Makanan', 'image_kw' => 'milk,can'],
            ['name' => 'Chitato Rasa Sapi Panggang 120gr', 'description' => 'Cemilan keripik kentang bergerigi paling digemari varian klasik daging sapi panggang BBQ.', 'price' => 20000, 'stock' => 200, 'category' => 'Makanan', 'image_kw' => 'potato,chips'],
            ['name' => 'Madu TJ Murni Organik 500gr', 'description' => 'Madu tropis murni tanpa bahan pengawet jaminan mutu Tresno Joyo. Membantu daya tahan tubuh ekstra.', 'price' => 65000, 'stock' => 110, 'category' => 'Makanan', 'image_kw' => 'honey,jar'],

            // Kecantikan (5)
            ['name' => 'Wardah Sunscreen Gel SPF 30 40ml', 'description' => 'Krim tabir surya ringan dengan proteksi SPF 30 PA+++. Cepat meresap nggak lengket.', 'price' => 35000, 'stock' => 250, 'category' => 'Kecantikan', 'image_kw' => 'sunscreen,skincare'],
            ['name' => 'Make Over Powerstay Matte Powder', 'description' => 'Bedak padat matte foundation dari Make Over, mengcover wajah dan menahan minyak luntur hingga 12 jam.', 'price' => 165000, 'stock' => 85, 'category' => 'Kecantikan', 'image_kw' => 'powder,makeup'],
            ['name' => 'Skintific 5X Ceramide Barrier Repair', 'description' => 'Pelembab wajah moisturizer cream bertekstur gel dengan kandungan 5 jenis ceramide buat memperbaiki skin barrier.', 'price' => 135000, 'stock' => 150, 'category' => 'Kecantikan', 'image_kw' => 'moisturizer,cream'],
            ['name' => 'Maybelline Superstay Matte Ink Lip Cream', 'description' => 'Lipstik matte cair intens dan tahan lama sepanjang hari (hingga 16 jam), tekstur ringan variansi ragam warna pigmen.', 'price' => 105000, 'stock' => 120, 'category' => 'Kecantikan', 'image_kw' => 'lipstick'],
            ['name' => 'Garnier Micellar Water Pink 400ml', 'description' => 'Pembersih wajah serbaguna cocok semua kulit. Mengangkat kotoran dan make up cepat tanpa bilas.', 'price' => 89000, 'stock' => 90, 'category' => 'Kecantikan', 'image_kw' => 'micellar,water'],

            // Otomotif (5)
            ['name' => 'Oli Mesin Shell Helix Astra 10W-30 4L', 'description' => 'Pelumas oli mesin mobil sintetis hemat bahan bakar dengan kebersihan partikel kotor. 4 Liter/ galon.', 'price' => 380000, 'stock' => 60, 'category' => 'Otomotif', 'image_kw' => 'oil,engine'],
            ['name' => 'Helm KYT Kaca Double Visor Half Face', 'description' => 'Helm motor half face standar SNI DOT dengan lisensi keamanan dan ganda visor hitam transparan.', 'price' => 450000, 'stock' => 20, 'category' => 'Otomotif', 'image_kw' => 'helmet,motorcycle'],
            ['name' => 'Wiper Mobil Bosch Clear Advantage', 'description' => 'Karet penyeka kaca mobil Bosch sepasang tanpa tulang / frameless universal, menyeka air hujan sangat bersih.', 'price' => 120000, 'stock' => 100, 'category' => 'Otomotif', 'image_kw' => 'wiper,car'],
            ['name' => 'Lampu LED Motor OSRAM H6 M5 Putih', 'description' => 'Lampu utama depan motor bebek atau matic LED Osram sinar super putih terang sorot 6000K.', 'price' => 55000, 'stock' => 140, 'category' => 'Otomotif', 'image_kw' => 'led,headlight'],
            ['name' => 'Ban Motor Michelin Pilot Sport 90/80-14', 'description' => 'Ban luar motor ukuran 90/80 ring 14 tubeless yang punya daya cengkram apik saat jalanan basah maupun kering.', 'price' => 300000, 'stock' => 40, 'category' => 'Otomotif', 'image_kw' => 'tire,motorcycle'],

            // Mainan (5)
            ['name' => 'LEGO Classic Creative Bricks 10692', 'description' => 'Kotak balok susun Lego kreatif untuk merangsang ide bangun mainan anak dari umur 4th+, terdapat instruksi ide menyusun.', 'price' => 300000, 'stock' => 55, 'category' => 'Mainan', 'image_kw' => 'lego,bricks'],
            ['name' => 'Hot Wheels City Diecast Random 5 Pack', 'description' => 'Mainan mobil mini diecast metal kolektor berisi 5 mobil model sport atau sport varian acak asli Mattel.', 'price' => 160000, 'stock' => 130, 'category' => 'Mainan', 'image_kw' => 'hotwheels,toy'],
            ['name' => 'Mainan Masak-masakan Dapur Pink Set', 'description' => 'Set maenan kasir atau dapur mini plastik, dengan lampu kelap piring dan teflon simulasi suara menggoreng.', 'price' => 110000, 'stock' => 60, 'category' => 'Mainan', 'image_kw' => 'toy,kitchen'],
            ['name' => 'Boneka Teddy Bear Beruang Besar 1 Meter', 'description' => 'Boneka hadiah ulang tahun beruang raksasa setinggi 1 meter berbahan bulu rasfur kapas sintetis yang halus peluk.', 'price' => 200000, 'stock' => 35, 'category' => 'Mainan', 'image_kw' => 'teddy,bear'],
            ['name' => 'Tembakan Air Water Gun Ransel Super', 'description' => 'Pistol air pompa tekanan tinggi plus ransel berbentuk tabung tanki di punggung. Pas untuk bermain basah basahan.', 'price' => 85000, 'stock' => 80, 'category' => 'Mainan', 'image_kw' => 'water,gun'],

            // Kesehatan (5)
            ['name' => 'Thermometer Digital Omron Pengukur Suhu', 'description' => 'Termometer klinis gun badan digital merk cepat rekam. Model tahan air dilengkapi bateri.', 'price' => 80000, 'stock' => 100, 'category' => 'Kesehatan', 'image_kw' => 'thermometer'],
            ['name' => 'Masker Medis Sensi Earloop 3 Ply Isi 50', 'description' => 'Masker bedah tali telinga box higienis. Filter anti kuman 3 lapis pernafasan tetap sejuk. Segel packing.', 'price' => 35000, 'stock' => 600, 'category' => 'Kesehatan', 'image_kw' => 'medical,mask'],
            ['name' => 'Hansaplast Plester Luka Transparan (Isi 100)', 'description' => 'Plester pembalut perban penutup luka lentur warna kulit anti air untuk pengobatan pertama harian.', 'price' => 20000, 'stock' => 250, 'category' => 'Kesehatan', 'image_kw' => 'plaster,wound'],
            ['name' => 'Blackmores Vitamin C 500mg (Isi 60 Tablet)', 'description' => 'Suplemen tablet nutrisi kekebalan harian kaya vit C. Jaga kesehatan dan cegah sakit tenggorokan flu batuk.', 'price' => 135000, 'stock' => 95, 'category' => 'Kesehatan', 'image_kw' => 'vitamins,pill'],
            ['name' => 'Tolak Angin Cair Herbal Sido Muncul (Isi 12)', 'description' => 'Ramuan masuk angin pereda mual nyeri kembung dengan sari jahe daun mint madu kemasan sachet cair seduh / minum.', 'price' => 45000, 'stock' => 350, 'category' => 'Kesehatan', 'image_kw' => 'herbal,medicine'],
        ];

        foreach ($products as $index => $data) {
            $product = Product::updateOrCreate(
                ['name' => $data['name']],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'category' => $data['category'],
                ]
            );

            // Fetch a random distinct placeholder strictly matching the product's keyword
            // The lock param avoids all identical keywords producing the same image
            ProductImage::updateOrCreate(['product_id' => $product->id], [
                'product_id' => $product->id,
                'image_path' => "https://loremflickr.com/640/480/" . urlencode($data['image_kw']) . "?lock=" . ($index + 1),
                'is_primary' => true,
            ]);
        }
    }
}