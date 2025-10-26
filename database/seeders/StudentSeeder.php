<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        $students = [
            [
                'full_name' => 'Ahmad Rizki Pratama',
                'nik' => '3577012008120001',
                'nisn' => '0012345678',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Pahlawan No. 15, Kelurahan Kartoharjo, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '081234567890',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Siti Nurhaliza',
                'nik' => '3577015209120002',
                'nisn' => '0012345679',
                'gender' => 'Perempuan',
                'address' => 'Jl. Serayu No. 8, Kelurahan Pangongangan, Kecamatan Manguharjo, Madiun',
                'phone_number' => '081234567891',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Dimas Adi Nugroho',
                'nik' => '3577011503120003',
                'nisn' => '0012345680',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Biliton No. 22, Kelurahan Mojorejo, Kecamatan Taman, Madiun',
                'phone_number' => '081234567892',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            [
                'full_name' => 'Putri Ayu Lestari',
                'nik' => '3577014206080001',
                'nisn' => '0087654321',
                'gender' => 'Perempuan',
                'address' => 'Jl. Slamet Riyadi No. 45, Kelurahan Demangan, Kecamatan Taman, Madiun',
                'phone_number' => '082345678901',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Muhammad Farhan Hakim',
                'nik' => '3577012511080002',
                'nisn' => '0087654322',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Yos Sudarso No. 12, Kelurahan Winongo, Kecamatan Manguharjo, Madiun',
                'phone_number' => '082345678902',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Anisa Rahmawati',
                'nik' => '3577015807090003',
                'nisn' => '0087654323',
                'gender' => 'Perempuan',
                'address' => 'Jl. Cokroaminoto No. 7, Kelurahan Oro-oro Ombo, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '082345678903',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Rian Firmansyah',
                'nik' => '3577011409080004',
                'nisn' => '0087654324',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Imam Bonjol No. 33, Kelurahan Banjarejo, Kecamatan Taman, Madiun',
                'phone_number' => '082345678904',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Devi Anggraeni',
                'nik' => '3577015203090005',
                'nisn' => '0087654325',
                'gender' => 'Perempuan',
                'address' => 'Jl. Mayjen Panjaitan No. 18, Kelurahan Pilangbango, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '082345678905',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Budi Santoso',
                'nik' => '3577012808080006',
                'nisn' => '0087654326',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Diponegoro No. 56, Kelurahan Kanigoro, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '082345678906',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Fitria Wulandari',
                'nik' => '3577014410090007',
                'nisn' => '0087654327',
                'gender' => 'Perempuan',
                'address' => 'Jl. Sultan Agung No. 9, Kelurahan Sukosari, Kecamatan Manguharjo, Madiun',
                'phone_number' => '082345678907',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            
            [
                'full_name' => 'Andika Putra Pratama',
                'nik' => '3577011705060001',
                'nisn' => '0065432109',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Veteran No. 28, Kelurahan Madiun Lor, Kecamatan Manguharjo, Madiun',
                'phone_number' => '083456789012',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Rina Kusuma Dewi',
                'nik' => '3577015612060002',
                'nisn' => '0065432110',
                'gender' => 'Perempuan',
                'address' => 'Jl. Ahmad Yani No. 41, Kelurahan Sogaten, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '083456789013',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Fajar Maulana',
                'nik' => '3577012302070003',
                'nisn' => '0065432111',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Gatot Subroto No. 67, Kelurahan Madiun Lor, Kecamatan Manguharjo, Madiun',
                'phone_number' => '083456789014',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Nadia Puspitasari',
                'nik' => '3577014408060004',
                'nisn' => '0065432112',
                'gender' => 'Perempuan',
                'address' => 'Jl. Sudirman No. 21, Kelurahan Pangongangan, Kecamatan Manguharjo, Madiun',
                'phone_number' => '083456789015',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Rizal Mahendra',
                'nik' => '3577011109070005',
                'nisn' => '0065432113',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Basuki Rahmat No. 14, Kelurahan Kejuron, Kecamatan Taman, Madiun',
                'phone_number' => '083456789016',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Ayu Lestari Ningrum',
                'nik' => '3577015506070006',
                'nisn' => '0065432114',
                'gender' => 'Perempuan',
                'address' => 'Jl. Wahidin No. 38, Kelurahan Nambangan Lor, Kecamatan Manguharjo, Madiun',
                'phone_number' => '083456789017',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Bayu Aji Pamungkas',
                'nik' => '3577013001060007',
                'nisn' => '0065432115',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Trunojoyo No. 52, Kelurahan Taman, Kecamatan Taman, Madiun',
                'phone_number' => '083456789018',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Citra Ayu Pramesti',
                'nik' => '3577016207060008',
                'nisn' => '0065432116',
                'gender' => 'Perempuan',
                'address' => 'Jl. Kapten Piere Tendean No. 19, Kelurahan Kelun, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '083456789019',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Galih Tri Saputra',
                'nik' => '3577012704070009',
                'nisn' => '0065432117',
                'gender' => 'Laki-laki',
                'address' => 'Jl. Letjen Suprapto No. 63, Kelurahan Jiwan, Kecamatan Kartoharjo, Madiun',
                'phone_number' => '083456789020',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'full_name' => 'Intan Permata Sari',
                'nik' => '3577015811060010',
                'nisn' => '0065432118',
                'gender' => 'Perempuan',
                'address' => 'Jl. Letjen MT Haryono No. 35, Kelurahan Manisrejo, Kecamatan Taman, Madiun',
                'phone_number' => '083456789021',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('students')->insert($students);
        
        $this->command->info('20 Students seeded successfully!');
    }
}
