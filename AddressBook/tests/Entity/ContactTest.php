<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    /** @var Contact */
    protected $contact;

    public function setUp()
    {
        $this->contact = new Contact();
    }

    public function testDefaultProperties()
    {
        $this->assertNull($this->contact->getFirstName());
    }

    public function testGetSetFirstName()
    {
        $this->assertEquals($this->contact, $this->contact->setFirstName('John'));
        $this->assertEquals('John', $this->contact->getFirstName());
    }
}
