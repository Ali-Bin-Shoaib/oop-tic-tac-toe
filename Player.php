<?php
class Player
{
    public int $id;

    public string $username;
    function __construct(string $username)
    {
        $this->username = $username;
        $this->id = time();
    }
}
