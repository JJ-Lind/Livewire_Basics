<?php

namespace Tests\Feature;

use App\Http\Livewire\DataTables;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class Data_Tables_Test extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function main_page_contains_data_tables_livewire_component()
    {
        $this->get('/users')->assertSeeLivewire('data-tables');
    }

    /** @test */
    public function data_tables_active_checkbox_works()
    {
        $user_active = User::create([
            'name' => 'User A',
            'email' => 'usera@email.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_inactive = User::create([
            'name' => 'User B',
            'email' => 'userb@email.com',
            'password' => bcrypt('password'),
            'active' => false
        ]);

        Livewire::test(DataTables::class)->assertSee($user_active->name)->assertDontSee($user_inactive->name)->set('active', false)->assertSee($user_inactive->name)->assertDontSee($user_active->name);
    }

    /** @test */
    public function data_tables_searches_name_correctly()
    {
        $user_active = User::create([
            'name' => 'User A',
            'email' => 'usera@email.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_inactive = User::create([
            'name' => 'User B',
            'email' => 'userb@email.com',
            'password' => bcrypt('password'),
            'active' => false
        ]);

        Livewire::test(DataTables::class)->set('search', 'user')->assertSee($user_active->name)->assertDontSee($user_inactive->name);
    }

    /** @test */
    public function data_tables_searches_email_correctly()
    {
        $user_active = User::create([
            'name' => 'User A',
            'email' => 'usera@email.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_inactive = User::create([
            'name' => 'User B',
            'email' => 'userb@email.com',
            'password' => bcrypt('password'),
            'active' => false
        ]);

        Livewire::test(DataTables::class)->set('search', 'usera@email.com')->assertSee($user_active->email)->assertDontSee($user_inactive->email);
    }

    /** @test */
    public function data_table_sorts_name_asc_correctly()
    {
        $user_c = User::create([
            'name' => 'Coraline Calmer',
            'email' => 'coraline@calmer.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_a = User::create([
            'name' => 'Angus Augustus',
            'email' => 'angus@augustus.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_b = User::create([
            'name' => 'Barry Benson',
            'email' => 'barry@benson.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        Livewire::test(DataTables::class)->call('sortBy', 'name')->assertSeeInOrder([
            'Angus Augustus',
            'Barry Benson',
            'Coraline Calmer',
        ]);
    }

    /** @test */
    public function data_table_sorts_name_desc_correctly()
    {
        $user_c = User::create([
            'name' => 'Coraline Calmer',
            'email' => 'coraline@calmer.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_a = User::create([
            'name' => 'Angus Augustus',
            'email' => 'angus@augustus.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_b = User::create([
            'name' => 'Barry Benson',
            'email' => 'barry@benson.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        Livewire::test(DataTables::class)->call('sortBy', 'name')->call('sortBy', 'name')->assertSeeInOrder([
            'Coraline Calmer',
            'Barry Benson',
            'Angus Augustus',
        ]);
    }

    /** @test */
    public function data_table_sorts_email_asc_correctly()
    {
        $user_c = User::create([
            'name' => 'Coraline Calmer',
            'email' => 'coraline@calmer.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_a = User::create([
            'name' => 'Angus Augustus',
            'email' => 'angus@augustus.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_b = User::create([
            'name' => 'Barry Benson',
            'email' => 'barry@benson.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        Livewire::test(DataTables::class)->call('sortBy', 'email')->assertSeeInOrder([
            'angus@augustus.com',
            'barry@benson.com',
            'coraline@calmer.com',
        ]);
    }

    /** @test */
    public function data_table_sorts_email_desc_correctly()
    {
        $user_c = User::create([
            'name' => 'Coraline Calmer',
            'email' => 'coraline@calmer.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_a = User::create([
            'name' => 'Angus Augustus',
            'email' => 'angus@augustus.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        $user_b = User::create([
            'name' => 'Barry Benson',
            'email' => 'barry@benson.com',
            'password' => bcrypt('password'),
            'active' => true
        ]);

        Livewire::test(DataTables::class)->call('sortBy', 'email')->call('sortBy', 'email')->assertSeeInOrder([
            'coraline@calmer.com',
            'barry@benson.com',
            'angus@augustus.com',
        ]);
    }
}
