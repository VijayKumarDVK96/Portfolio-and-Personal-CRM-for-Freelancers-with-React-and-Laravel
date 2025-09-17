<?php

namespace Tests\Feature;
namespace App\Http\Traits;

trait TestTrait {

    public function testPostMethod($url, $array, $session_message) {

        $response = $this->post($url, $array);
        
        foreach($array as $key => $value) {
            $response->assertSessionHasNoErrors($key);
        }
        
        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'message' => $session_message
        ]);

        return $response;
    }
}