<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Models\User;
use App\Http\Models\PersonalVault;
use App\Http\Models\VaultsCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminTest extends TestCase {

    use DatabaseTransactions;

    public function testloginWithFakeUser() {
        
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('admin/')
            ->assertSeeText('Dashboard');
    }

    public function testaddPersonalVault() {
        $this->testloginWithFakeUser();
        
        $vault_category = VaultsCategory::first();

        $data =
            array(
                'vaults_category_id' => $vault_category->id,
                'url' => 'www.google.com',
                'username' => 'Isabelle Shaffer',
                'password' => 'passsdfsf',
                'notes' => 'Test Note',
            );

        $response = $this->post('admin/add-new-personal-vault', $data);

        foreach ($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }

        // $response->dump();
        // exit;

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Added new credentials'
        ]);
    }

    public function testupdatePersonalVault() {
        $this->testloginWithFakeUser();

        $vault_category = VaultsCategory::first();
        $vault = PersonalVault::first();

        $data =
            array(
                'vaults_category_id' => $vault_category->id,
                'url' => 'www.google.com',
                'username' => 'Isabelle Shaffer',
                'password' => 'passsdfsf',
                'notes' => 'Test Notes',
            );

        $response = $this->post('admin/update-personal-vault/' . $vault->id, $data);

        foreach ($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }

        // $response->dump();
        // exit;

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Updated credentials'
        ]);
    }

}
