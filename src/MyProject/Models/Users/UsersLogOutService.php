<?php 
namespace MyProject\Models\Users;

class UsersLogOutService
{
    public static function deleteToken(): void
    {
        setcookie('token', '', time() - 3600, '/');
    }
}
?>