<?php

namespace Tests\Feature;

use App\Models\Servico;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SistemaTest extends TestCase
{
    use DatabaseTransactions;

    public function test_usuario_consegue_fazer_login_e_acessar_clientes(): void
    {
        User::factory()->create([
            'email' => 'teste-login@salaobeleza.com',
            'password' => Hash::make('password'),
        ]);

        $this->post('/login', [
            'email' => 'teste-login@salaobeleza.com',
            'password' => 'password',
        ])->assertRedirect(route('cliente.index'));

        $this->get('/cliente')->assertOk();
    }

    public function test_busca_de_servicos_funciona(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Servico::factory()->create(['nome_servico' => 'Corte clássico']);
        Servico::factory()->create(['nome_servico' => 'Manicure']);

        $this->actingAs($user)
            ->post('/servico/search', ['valor' => 'Corte'])
            ->assertOk()
            ->assertSee('Corte clássico')
            ->assertDontSee('Manicure');
    }

    public function test_cliente_exige_campos_obrigatorios(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/cliente', [])
            ->assertSessionHasErrors(['nome', 'cpf', 'telefone']);
    }
}
