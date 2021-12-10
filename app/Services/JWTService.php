<?php
namespace App\Services;

use App\Exceptions\ApiException;
use Auth0\SDK\Auth0;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Exception\NetworkException;
use Auth0\SDK\Token;
use Illuminate\Http\Request;

class JWTService implements JWTServiceInterface
{
    private Auth0 $auth0;

    const MESSAGE_BAD_CREDENTIALS = 'Bad credentials';
    const UNABLE_TO_VERIFY = 'Unable to verify credentials';

    public function __construct(Auth0 $auth0)
    {
        $this->auth0 = $auth0;
    }

    public function extractBearerTokenFromRequest(Request $request): string
    {
        $authorization = $request->headers->get('authorization');

        if (empty($authorization)) {
            throw new ApiException('Requires authentication', 401);
        }

        $parts = explode(' ', $authorization);

        if (count($parts) !== 2) {
            throw ApiException::withDetails([
                'error' => 'invalid_request',
                'error_description' => 'Authorization header value must follow this format: Bearer access-token',
                'message' => self::MESSAGE_BAD_CREDENTIALS
            ], 401);
        }

        [$authScheme, $bearerToken] = $parts;

        if (strtolower($authScheme) !== 'bearer') {
            throw new ApiException(self::MESSAGE_BAD_CREDENTIALS, 401);
        }

        return $bearerToken;
    }

    public function decodeBearerToken(string $token): array
    {
        try {
            $token = $this->auth0->decode(
                $token,
                config('auth0.audience'),
                null,
                null,
                null,
                null,
                null,
                Token::TYPE_TOKEN
            );

            return $token->toArray();
        } catch (NetworkException $ex) {
            throw ApiException::withDetails([
                'error' => 'signing_key_unavailable',
                'error_description' => 'Unable to fetch signing key',
                'message' => self::UNABLE_TO_VERIFY
            ], 500);
        } catch (InvalidTokenException $ex) {
            throw ApiException::withDetails([
                'error' => 'invalid_token',
                'error_description' => $ex->getMessage(),
                'message' => self::MESSAGE_BAD_CREDENTIALS
            ], 401);
        } catch (\JsonException $ex) {
            throw ApiException::withDetails([
                'error' => 'invalid_token',
                'error_description' => "Invalid token",
                'message' => self::MESSAGE_BAD_CREDENTIALS
            ], 401);
        } catch (\Exception $ex) {
            throw new ApiException('Internal Server Error', 500);
        }
    }
}
