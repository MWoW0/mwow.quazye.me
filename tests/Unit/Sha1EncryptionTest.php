<?php

namespace Tests\Unit;

use App\Hashing\SillySha1;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Sha1EncryptionTest extends TestCase
{
	/** @test */
	   function itEncryptsTheValue() 
	   {
	   		$expected = '0639C9915279A92A5AAF84FF50FBA680B06152CF'; // secret

	   		$hasher = new SillySha1;

	   		$this->assertEquals($expected, $hasher->make('secret', ['user' => 'john']));
	   }    
}