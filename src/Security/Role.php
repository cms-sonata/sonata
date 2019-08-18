<?php

namespace App\Security;

/**
 * Class Role
 *
 * @package App\Security
 */
final class Role
{
    /**
     * @var array
     */
    private $roles = [];

    function __construct()
    {
        $this->roles = [
            1 => 'ROLE_USER',
            2 => 'ROLE_REDACTOR',
            3 => 'ROLE_MODERATOR',
            4 => 'ROLE_ADMIN',
        ];
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->roles;
    }

    /**
     * @param int $inputRole
     *
     * @return string
     */
    public function get(int $inputRole): string
    {
        return $this->roles[$inputRole] ?? '';
    }
}