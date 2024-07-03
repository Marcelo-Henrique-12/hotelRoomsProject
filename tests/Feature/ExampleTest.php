<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa o redirecionamento para o login quando não autenticado.
     */
    public function test_redirect_to_login_when_not_authenticated(): void
    {
        // Faz a requisição GET para '/'
        $response = $this->get('/');

        // Verifica se houve redirecionamento para a rota de login
        $response->assertStatus(302); // Deve redirecionar para /login
        $response->assertRedirect('/login');
    }

    /**
     * Testa se a aplicação retorna uma resposta bem-sucedida quando autenticado.
     */
    public function test_successful_response_when_authenticated(): void
    {
        // Cria um usuário e autentica
        $user = User::factory()->create();
        $this->actingAs($user);

        // Faz a requisição GET para '/'
        $response = $this->get('/');

        // Verifica se a resposta tem status 200 (bem-sucedida)
        $response->assertStatus(200);
    }
}
