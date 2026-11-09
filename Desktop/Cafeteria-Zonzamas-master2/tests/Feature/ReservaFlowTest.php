<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Producto;
use App\Models\Reserva;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReservaFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Los tests no dependen de que Vite esté compilado.
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);

        // Siempre a media mañana, dentro del horario de la cafetería.
        Carbon::setTestNow(Carbon::today()->setTime(9, 0));
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    private function cliente(): User
    {
        return User::where('email', 'cliente@zonzamas.es')->firstOrFail();
    }

    public function test_el_seeder_crea_la_carta(): void
    {
        $this->assertGreaterThan(10, Producto::count());
    }

    public function test_la_carta_requiere_login_y_se_muestra(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');

        $this->actingAs($this->cliente())
            ->get('/dashboard')
            ->assertOk()
            ->assertSee('Café solo');
    }

    public function test_se_registra_siempre_como_cliente(): void
    {
        $this->post('/register', [
            'name' => 'Nuevo',
            'telefono' => '600111222',
            'email' => 'nuevo@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'tipo' => 'admin', // intento de colarse como admin
        ])->assertRedirect('/dashboard');

        $this->assertSame('cliente', User::where('email', 'nuevo@example.com')->first()->tipo);
    }

    public function test_anadir_suma_cantidades_y_respeta_el_stock(): void
    {
        $user = $this->cliente();
        $producto = Producto::where('nombre', 'Donut')->firstOrFail();

        $this->actingAs($user)->postJson('/cart/add', ['id_producto' => $producto->id_producto, 'cantidad' => 2])
            ->assertOk()->assertJson(['success' => true, 'count' => 2]);
        $this->actingAs($user)->postJson('/cart/add', ['id_producto' => $producto->id_producto, 'cantidad' => 3])
            ->assertOk()->assertJson(['count' => 5]);

        $this->assertSame(1, Cart::where('id_user', $user->id)->count());

        $producto->update(['stock' => 5]);
        $this->actingAs($user)->postJson('/cart/add', ['id_producto' => $producto->id_producto, 'cantidad' => 1])
            ->assertStatus(422);
    }

    public function test_confirmar_la_reserva_descuenta_stock_y_vacia_el_carrito(): void
    {
        $user = $this->cliente();
        $producto = Producto::where('nombre', 'Donut')->firstOrFail();
        $stockInicial = $producto->stock;

        Cart::create(['id_user' => $user->id, 'id_producto' => $producto->id_producto, 'cantidad' => 3]);

        $this->actingAs($user)
            ->post('/cart/confirmar', ['hora_recogida' => '11:00'])
            ->assertRedirect('/reservas');

        $reserva = Reserva::where('id_cliente', $user->id)->firstOrFail();
        $this->assertSame('pendiente', $reserva->estado);
        $this->assertEquals(3.00, (float) $reserva->total);
        $this->assertSame(1, $reserva->lineas()->count());
        $this->assertSame($stockInicial - 3, $producto->fresh()->stock);
        $this->assertSame(0, Cart::where('id_user', $user->id)->count());

        // Cancelar devuelve el stock.
        $this->actingAs($user)->patch("/reservas/{$reserva->id_reserva}/cancelar")->assertRedirect();
        $this->assertSame('cancelada', $reserva->fresh()->estado);
        $this->assertSame($stockInicial, $producto->fresh()->stock);
    }

    public function test_hora_fuera_de_horario_se_rechaza(): void
    {
        $user = $this->cliente();
        $producto = Producto::firstOrFail();
        Cart::create(['id_user' => $user->id, 'id_producto' => $producto->id_producto, 'cantidad' => 1]);

        $this->actingAs($user)
            ->post('/cart/confirmar', ['hora_recogida' => '20:00'])
            ->assertSessionHasErrors('hora_recogida');

        $this->assertSame(0, Reserva::count());
    }

    public function test_un_cliente_no_puede_tocar_el_carrito_de_otro(): void
    {
        $otro = User::where('email', 'gerente@zonzamas.es')->firstOrFail();
        $item = Cart::create([
            'id_user' => $otro->id,
            'id_producto' => Producto::firstOrFail()->id_producto,
            'cantidad' => 1,
        ]);

        $this->actingAs($this->cliente())->delete("/cart/{$item->id}")->assertForbidden();
    }

    public function test_solo_el_personal_accede_a_la_gestion(): void
    {
        $this->actingAs($this->cliente())->get('/gestion/reservas')->assertForbidden();

        $this->actingAs(User::where('email', 'camarero@zonzamas.es')->firstOrFail())
            ->get('/gestion/reservas')
            ->assertOk();
    }
}
