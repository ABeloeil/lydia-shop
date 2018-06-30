<?php

namespace AppBundle\Model;


use CommerceGuys\Enum\AbstractEnum;

final class TransactionStatus extends AbstractEnum
{
    const PENDING = 'pending';
    const SUCCESS = 'success';
    const FAILED  = 'failed';
}
