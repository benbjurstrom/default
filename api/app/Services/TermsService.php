<?php
namespace App\Services;

use App\Models\User;
use App\Models\UserAgreement;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class TermsService
{

    /**
     * @param User $user
     * @return bool
     */
    public function userHasAgreedToAll(User $user): bool
    {
        return $this->userHasAgreedToTerms($user) && $this->userHasAgreedToPrivacy($user);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userHasAgreedToTerms(User $user): bool
    {
        $terms_sha = $this->getTermsAgreement()->sha;
        return $user->agreements()->where('sha', $terms_sha)->exists();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function userHasAgreedToPrivacy(User $user): bool
    {
        $privacy_sha = $this->getPrivacyAgreement()->sha;
        return $user->agreements()->where('sha', $privacy_sha)->exists();
    }

    /**
     * @return mixed
     */
     public function getTermsAgreement(){
        $terms = Cache::get('agreements.terms');
        if($terms && property_exists($terms, 'sha')) {
            return $terms;
        }

        $terms = $this->load('terms');
        Cache::put('agreements.terms', $terms, 60 * 60);
        return $terms;
    }

    /**
     * @return mixed
     */
    public function getPrivacyAgreement(){
        $terms = Cache::get('agreements.privacy');
        if($terms && property_exists($terms, 'sha')) {
            return $terms;
        }

        $terms = $this->load('privacy');
        Cache::put('agreements.privacy', $terms, 60 * 60);
        return $terms;
    }

    /**
     * @param string $type
     * @return mixed
     * @throws
     */
     protected function load($type){
        $client = new Client(['base_uri' => 'https://api.github.com/repos/']);
        $response = $client->request('GET', $this->getUri($type));
        $body = $response->getBody();
        $result = json_decode($body->getContents());
        return $result;
    }

    /**
     * @param string $type
     * @return string
     */
     protected function getUri($type){
        $repo  = config('terms.repository');
        $files = config('terms.files');

        return $repo . '/contents/' . $files[$type];
    }
}