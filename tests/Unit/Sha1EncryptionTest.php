<?php

namespace Tests\Unit;

use App\Hashing\Sha1Hasher;
use Tests\TestCase;

class Sha1EncryptionTest extends TestCase
{
	/** @test */
	   function itEncryptsTheValue() 
	   {
	   		$expected = '0639C9915279A92A5AAF84FF50FBA680B06152CF'; // secret

           $hasher = new Sha1Hasher;

	   		$this->assertEquals($expected, $hasher->make('secret', ['user' => 'john']));
	   }    
}