<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MultiSppgSeeder extends Seeder
{
    public function run()
    {
        $sppgs = [
            'Bunar',
            'Tigaraksa',
            'Tobat',
            'Cikupa',
            'Curug',
            'Sepatan Timur',
            'Sepatan Induk',
            'Pasar Kemis',
            'Sukadiri'
        ];

        $roles = ['aslap', 'akuntan', 'ahli_gizi', 'pic'];

        foreach ($sppgs as $sName) {
            // Insert SPPG
            $this->db->table('sppgs')->insert([
                'nama_sppg'  => 'SPPG ' . $sName,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $sppgId = $this->db->insertID();

            // Create users for each role in this SPPG
            foreach ($roles as $role) {
                $cleanName = strtolower(str_replace(' ', '_', $sName));
                $username  = $role . '_' . $cleanName;
                $password  = password_hash($role . '123', PASSWORD_DEFAULT);

                $userData = [
                    'nama'       => ucfirst($role) . ' ' . $sName,
                    'username'   => $username,
                    'password'   => $password,
                    'role'       => $role,
                    'sppg_id'    => $sppgId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];

                $this->db->table('users')->insert($userData);
            }
        }

        // Ensure Admin exists (not linked to any SPPG)
        $admin = $this->db->table('users')->where('username', 'admin')->get()->getRow();
        if (!$admin) {
            $this->db->table('users')->insert([
                'nama'       => 'Super Admin',
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'sppg_id'    => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
