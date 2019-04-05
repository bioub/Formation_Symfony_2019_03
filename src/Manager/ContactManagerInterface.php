<?php


namespace App\Manager;


use App\Entity\Contact;

interface ContactManagerInterface
{
    public function count(): int;
    public function getAll(): array;
    public function getById(string $id): Contact;
    public function save(Contact $contact): void;
}