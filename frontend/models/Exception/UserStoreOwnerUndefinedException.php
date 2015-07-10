<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 24.06.2015
 * Time: 9:43
 */

namespace frontend\models\Exception;


use common\models\User;
use Exception;

class UserStoreOwnerUndefinedException extends \LogicException
{

    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     * @param string $message
     * @param int $code
     * @param Exception $previous
     */
    public function __construct(User $user, $message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}