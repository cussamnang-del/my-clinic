<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('permissions', function (Blueprint $table) {
        $table->id();
        $table->string('group')->nullable();
        $table->string('title')->nullable();
        $table->boolean('status')->default(true);
        $table->timestamps();
        $table->softDeletes();
      });

      $permissions = [
        [
            'title' => 'user_management_access',
            'group' => 'User Management'
        ],
        [
            'title' => 'permission_create',
            'group' => 'Permission'
        ],
        [
            'title' => 'permission_edit',
            'group' => 'Permission'
        ],
        [
            'title' => 'permission_show',
            'group' => 'Permission'
        ],
        [
            'title' => 'permission_delete',
            'group' => 'Permission'
        ],
        [
            'title' => 'permission_access',
            'group' => 'Permission'
        ],
        [
            'title' => 'role_create',
            'group' => 'Role'
        ],
        [
            'title' => 'role_edit',
            'group' => 'Role'
        ],
        [
            'title' => 'role_show',
            'group' => 'Role'
        ],
        [
            'title' => 'role_delete',
            'group' => 'Role'
        ],
        [
            'title' => 'role_access',
            'group' => 'Role'
        ],
        [
            'title' => 'user_create',
            'group' => 'User'
        ],
        [
            'title' => 'user_edit',
            'group' => 'User'
        ],
        [
            'title' => 'user_show',
            'group' => 'User'
        ],
        [
            'title' => 'user_delete',
            'group' => 'User'
        ],
        [
            'title' => 'user_access',
            'group' => 'User'
        ],
        [
            'title' => 'profile_password_edit',
            'group' => 'Profile'
        ],
      ];
      // Permission::insert($permissions);
      DB::table('permissions')->insert($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
