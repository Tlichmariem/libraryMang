<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppLoginAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }

    public function authenticate(Request $request): Passport
    {
        // Récupération de l'email et du mot de passe à partir des données de la requête
        $email = $request->request->get('email'); // Changer getPayload() en request->get()
        $password = $request->request->get('password'); // Idem pour le mot de passe

        // Stockage du dernier email soumis dans la session pour le formulaire de connexion
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        // Retour d'un Passport avec un UserBadge et un PasswordCredentials
        return new Passport(
            new UserBadge($email), // Cette méthode charge l'utilisateur en fonction de l'email
            new PasswordCredentials($password), // Les informations d'identification
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')), // Protection CSRF
                new RememberMeBadge(), // Si "Se souvenir de moi" est activé
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Si l'utilisateur avait une destination après la connexion, redirige vers cette page
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Sinon, redirection vers la page d'accueil (modifiez ici si nécessaire)
        return new RedirectResponse($this->urlGenerator->generate('app_home'));  // Assurez-vous que 'app_home' existe
    }

    protected function getLoginUrl(Request $request): string
    {
        // Retourne l'URL du formulaire de connexion
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
