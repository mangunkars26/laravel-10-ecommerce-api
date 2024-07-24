<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_address_successful()
    {
        // Buat pengguna dan login
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        // Data untuk request
        $data = [
            'alamat' => 'Jalan Kenanga No. 12',
            'kel' => 'Kelurahan Mawar',
            'kec' => 'Kecamatan Melati',
            'kota' => 'Kota Anggrek',
            'prov' => 'Provinsi Bunga',
            'kodepos' => '12345'
        ];

        // Kirim request POST
        $response = $this->postJson('/api/simpan-alamat', $data);

        // Cek respons dan status code
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Alamat telah ditambahkan']);

        // Cek database
        $this->assertDatabaseHas('addresses', [
            'alamat' => 'Jalan Kenanga No. 12',
            'kel' => 'Kelurahan Mawar',
            'kec' => 'Kecamatan Melati',
            'kota' => 'Kota Anggrek',
            'prov' => 'Provinsi Bunga',
            'kodepos' => '12345',
            'user_id' => $user->id
        ]);
    }

    public function test_store_address_validation_error()
    {
        // Buat pengguna dan login
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        // Data untuk request yang tidak lengkap
        $data = [
            'alamat' => '',
            'kel' => '',
            'kec' => '',
            'kota' => '',
            'prov' => '',
            'kodepos' => ''
        ];

        // Kirim request POST
        $response = $this->postJson('/api/simpan-alamat', $data);

        // Cek respons dan status code
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['alamat', 'kel', 'kec', 'kota', 'prov', 'kodepos']);
    }
}
