<?php

namespace Tests\Feature\User;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase {
    use RefreshDatabase;

    protected function successfulRegistrationRoute() {
        return route('home');
    }

    protected function registerGetRoute() {
        return route('register');
    }

    protected function registerPostRoute() {
        return route('register');
    }

    protected function guestMiddlewareRoute() {
        return route('home');
    }

    public function testUserCanViewARegistrationForm() {
        $response = $this->get($this->registerGetRoute());
        $response->assertSuccessful();
        $response->assertViewIs('auth.register');
    }
    public function testUserCannotViewARegistrationFormWhenAuthenticated()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)->get($this->registerGetRoute());

        $response->assertRedirect($this->guestMiddlewareRoute());
    }

    public function testUserCanRegister()
    {
        
        Event::fake();
        $response = $this->post($this->registerPostRoute(), [
            'name' => 'johndoe',
            'email' => 'john@example.com',
            'password' => 'secretpassword',
            'password_confirmation' => 'secretpassword',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'pesel' => '69100782784',
            'languages' => 'Java, PHP',
        ]);

        $response->assertRedirect($this->successfulRegistrationRoute());
        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());
        $this->assertEquals('johndoe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('secretpassword', $user->password));
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertEquals('69100782784', $user->pesel);
        Event::assertDispatched(Registered::class, function ($e) use ($user) {
            return $e->user->id === $user->id;
        });
    }
    
}
