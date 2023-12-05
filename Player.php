<?php
class Player
{
    public string $id;

    public string $username;
    function __construct(string $username)
    {
        $this->username = $username;
        $this->id = md5(uniqid());
    }
}
