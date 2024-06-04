<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase; 

    public function testUserName()
    {
        $user = new User(['name' => 'Test User']);
        $this->assertEquals('Test User', $user->name);
    }

    public function testUserEmail()
    {
        $user = new User(['email' => 'test@example.com']);
        $this->assertEquals('test@example.com', $user->email);
    }

    public function testUserPassword()
    {
        $user = new User(['password' => Hash::make('secret')]);
        $this->assertTrue(Hash::check('secret', $user->password));
    }

    public function testHiddenAttributes()
    {
        $user = new User();
        $hidden = $user->getHidden();
        $this->assertContains('password', $hidden);
        $this->assertContains('remember_token', $hidden);
    }

    public function testCasts()
    {
        $user = new User();
        $casts = $user->getCasts();
        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }

    public function testGetJWTIdentifier()
    {
        $user = User::factory()->create(['id' => 1]);
        $this->assertEquals(1, $user->getJWTIdentifier());
    }

    public function testGetJWTCustomClaims()
    {
        $user = new User();
        $this->assertIsArray($user->getJWTCustomClaims());
        $this->assertEmpty($user->getJWTCustomClaims());
    }
}
