<?php

namespace Database\Seeders;

use App\Models\AccessLevel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $artistePermissions = [
            'download_beat',
            'buy_beat',
            'play_beat'
        ];

        $producerPermissions = [
          'sell_beat',
          'upload_beat',
          'delete_beat'
        ];

        foreach($artistePermissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }

        foreach($producerPermissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'api'
            ]);
        }


        $artiste = Role::create(['name' => 'artiste', 'guard_name' => 'api']);
        $producer = Role::create(['name' => 'producer', 'guard_name' => 'api']);
        // $author = Role::create(['name' => 'author', 'guard_name' => 'api']);

        $artiste->syncPermissions($artistePermissions);
        $producer->syncPermissions($producerPermissions);
    }
}
