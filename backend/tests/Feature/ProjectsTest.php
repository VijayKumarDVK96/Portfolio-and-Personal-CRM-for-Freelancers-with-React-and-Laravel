<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Models\User;
use App\Http\Models\Clients;
use App\Http\Models\Project;
use App\Http\Models\ProjectMilestone;
use Illuminate\Support\Facades\DB;
use App\Http\Models\ProjectsCategory;
use App\Http\Models\Vault;
use App\Http\Models\VaultsCategory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectsTest extends TestCase {
    
    use DatabaseTransactions;

    public $insert_id;

    public function testloginWithFakeUser() {
        
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->withSession(['foo' => 'bar'])
            ->get('admin/')
            ->assertSeeText('Dashboard');
    }

    public function testaddProjectCategory() {
        $this->testloginWithFakeUser();
        
        $data = array(
                'name' => 'Isabelle Shaffer'
            );

        $response = $this->post('admin/add-project-category', $data);
        
        foreach($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Category Added'
        ]);
    }

    public function testaddProjectTechnology() {
        $this->testloginWithFakeUser();
        
        $data =
            array(
                'name' => 'Isabelle Shaffer'
            );

        $response = $this->post('admin/add-project-technology', $data);
        // $response->dump();
        // exit;
        
        foreach($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Technology Added'
        ]);
    }

    public function testaddProject() {
        $this->testloginWithFakeUser();

        $category = ProjectsCategory::select('id')->first();
        $client = Clients::select('id')->first();
        
        $data =
            array(
                'name' => 'Isabelle Shaffer',
                'projects_category_id' => $category->id,
                'client_id' => $client->id,
                'technology' => [1,2,3,4],
                'deadline' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );

        $response = $this->post('admin/add-new-project', $data);

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
            'message' => 'Project Added'
        ]);
    }

    public function testupdateProject() {
        $this->testloginWithFakeUser();

        $category = ProjectsCategory::select('id')->first();
        $client = Clients::select('id')->first();
        $project = Project::first();
        
        $data =
            array(
                'name' => 'Isabelle Shaffer',
                'projects_category_id' => $category->id,
                'client_id' => $client->id,
                'technology' => [1,2,3,4],
                'estimated_price' => '10',
                'total_price' => '10',
                'description' => 'Lorem ipsum',
                'deadline' => date('Y-m-d H:i:s'),
            );

        $response = $this->post('admin/update-project/'.$project->id, $data);

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
            'message' => 'Project Updated'
        ]);
    }

    public function testaddVaultCategory() {
        $this->testloginWithFakeUser();
        
        $data =
            array(
                'name' => 'Isabelle Shaffer'
            );

        $response = $this->post('admin/add-vault-category', $data);
        
        foreach($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }

        // $response->dump();
        // exit;
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Category Added'
        ]);
    }

    public function testaddVault() {
        $this->testloginWithFakeUser();

        $project = Project::first();
        $vault_category = VaultsCategory::first();
        
        $data =
            array(
                'vaults_category_id' => $vault_category->id,
                'project_id' => $project->id,
                'url' => 'www.google.com',
                'username' => 'Isabelle Shaffer',
                'password' => 'passsdfsf',
                'notes' => 'Test Note',
            );

        $response = $this->post('admin/add-new-vault/'.$project->id, $data);
        
        foreach($data as $key => $value) {
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

    public function testupdateVault() {
        $this->testloginWithFakeUser();

        $vault_category = VaultsCategory::first();
        $vault = Vault::first();
        
        $data =
            array(
                'vaults_category_id' => $vault_category->id,
                'url' => 'www.google.com',
                'username' => 'Isabelle Shaffer',
                'password' => 'passsdfsf',
                'notes' => 'Test Note',
            );

        $response = $this->post('admin/update-vault/'.$vault->id, $data);
        
        foreach($data as $key => $value) {
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

    public function testaddProjectMilestone() {
        $this->testloginWithFakeUser();

        $project = Project::first();
        
        $data = array(
                'name' => 'Isabelle Shaffer'
            );

        $response = $this->post('admin/add-milestone/'.$project->id, $data);
        
        foreach($data as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Added new milestone'
        ]);
    }

    public function testupdateProjectMilestoneStatus() {
        $this->testloginWithFakeUser();

        $project = ProjectMilestone::first();

        $response = $this->get('admin/update-milestone/'.$project->id.'/update');
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Updated milestone'
        ]);
    }

    public function testdeleteProjectMilestone() {
        $this->testloginWithFakeUser();

        $project = ProjectMilestone::first();

        $response = $this->get('admin/update-milestone/'.$project->id.'/delete');
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => 'Deleted milestone'
        ]);
    }
}
