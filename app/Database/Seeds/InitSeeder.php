<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class InitSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $users = [
            [
                'nama'     => 'Administrator',
                'username' => 'admin',
                'password' => 'admin123',
                'role'     => 'admin',
                'email'    => 'admin@sppg.com',
            ],
            [
                'nama'     => 'Person In Charge',
                'username' => 'pic',
                'password' => 'pic123',
                'role'     => 'pic',
                'email'    => 'pic@sppg.com',
            ],
            [
                'nama'     => 'Asisten Lapangan',
                'username' => 'aslap',
                'password' => 'aslap123',
                'role'     => 'aslap',
                'email'    => 'aslap@sppg.com',
            ],
            [
                'nama'     => 'Akuntan',
                'username' => 'akuntan',
                'password' => 'akuntan123',
                'role'     => 'akuntan',
                'email'    => 'akuntan@sppg.com',
            ],
            [
                'nama'     => 'Ahli Gizi',
                'username' => 'ahligizi',
                'password' => 'ahligizi123',
                'role'     => 'ahli_gizi',
                'email'    => 'ahligizi@sppg.com',
            ],
        ];

        foreach ($users as $user) {
            // Check if user already exists
            if (! $userModel->where('username', $user['username'])->first()) {
                $userModel->insert($user);
            }
        }

        echo "✅ Seeder berhasil: 5 user (admin, pic, aslap, akuntan, ahligizi) telah dibuat.\n";
    }
}
