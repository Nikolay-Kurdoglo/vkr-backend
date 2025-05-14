<?php

declare(strict_types=1);

namespace App\Helper;

use App\Exception\InvalidAuthorizationToken;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\ConstraintViolation;
use Lcobucci\JWT\Validation\Validator;

class JwtHelper
{
    /**
     * @throws InvalidAuthorizationToken
     */
    public static function isValid(string $token): void
    {
        try {
            $parser = new Parser(new JoseEncoder());

            $token = $parser->parse($token);
            $key = InMemory::base64Encoded((string) getenv('SECRET_KEY'));

            (new Validator())
                ->validate($token, new SignedWith(new Sha256(), $key));
        } catch(ConstraintViolation $e) {
            $message = $e->getMessage();

            switch ($message) {
                case 'Token signature mismatch':
                throw new InvalidAuthorizationToken('Token invalid');
            }
        }
    }
}
