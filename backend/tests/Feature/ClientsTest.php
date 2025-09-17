<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Models\User;
use App\Http\Models\Clients;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ClientsTest extends TestCase {

    use DatabaseTransactions;

    public $insert_id;

    public function testloginWithFakeUser() {
        
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('admin/')
            ->assertSeeText('Dashboard');

        // $response->dumpHeaders();
        // $response->dumpSession();
        // $response->dump();
    }

    public function testaddClient() {
        $this->testloginWithFakeUser();
        
        $data =
            array(
                'full_name' => 'Isabelle Shaffer',
                'company_name' => 'Mcfadden and Griffith LLC',
                'company_website' => 'https://www.xoqijosowitakug.tv',
                'gender' => 'Female',
                'role' => 'Nulla molestias exce',
                'email' => 'milym@mailinator.com',
                'mobile' => '4',
                'address' => 'Quas ut voluptatem s',
                'state' => '37',
                'city' => '3560',
                'created_at' => date('Y-m-d H:i:s'),
            );

        $response = $this->post('admin/create-client', $data);
        $this->insert_id = DB::getPdo()->lastInsertId();

        // $response->dumpHeaders();
        // $response->dumpSession();
        // $response->dump();
        // exit;
        
        foreach($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'New Client Created'
        ]);
    }

    public function testupdateClient() {
        $this->testloginWithFakeUser();
        $this->testaddClient();

        $data =
            array(
                'id' => $this->insert_id,
                'full_name' => 'Isabelle Shaffer',
                'company_name' => 'Mcfadden and Griffith LLC',
                'company_website' => 'https://www.xoqijosowitakug.tv',
                'gender' => 'Female',
                'role' => 'Nulla molesstias exce',
                'email' => 'milym@mailinator.com',
                'mobile' => '4',
                'address' => 'Quas ut voluptatem s',
                'state' => '37',
                'city' => '3560',
            );

        $response = $this->post('admin/update-client/'.$this->insert_id, $data);

        foreach ($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Client Details Updated'
        ]);
    }
}
