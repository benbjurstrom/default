<?php

namespace Tests\Feature\Services;

use App\Models\User;
use App\Services\AuthService;
use App\Services\TermsService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cache;

class TermsServiceTest extends TestCase
{

    /**
     * @test
     */
    function testGetTermsAgreementHitsCache(){
        $terms = new \stdClass();
        $terms->sha = sha1('test');
        Cache::shouldReceive('get')
            ->once()
            ->with('agreements.terms')
            ->andReturn($terms);
        $result = (new TermsService())->getTermsAgreement();
        $this->assertEquals($terms, $result);
    }

    /**
     * @test
     */
    function testGetPrivacyAgreementHitsCache(){
        $terms = new \stdClass();
        $terms->sha = sha1('test');
        Cache::shouldReceive('get')
            ->once()
            ->with('agreements.privacy')
            ->andReturn($terms);
        $result = (new TermsService())->getPrivacyAgreement();
        $this->assertEquals($terms, $result);
    }

    /**
     * @test
     */
    function testGetTermsAgreementCallsLoad(){
        Cache::forget('agreements.terms');
        $mock = \Mockery::mock(TermsService::class . '[load]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('load')
            ->with('terms')
            ->once()
            ->andReturn('result')
            ->getMock();

        $result = $mock->getTermsAgreement();
        $this->assertEquals($result, $result);
    }

    /**
     * @test
     */
    function testGetPrivacyAgreementCallsLoad(){

        Cache::forget('agreements.privacy');
        $mock = \Mockery::mock(TermsService::class . '[load]')
            ->shouldAllowMockingProtectedMethods()
            ->shouldReceive('load')
            ->with('privacy')
            ->once()
            ->andReturn('result')
            ->getMock();

        $result = $mock->getPrivacyAgreement();
        $this->assertEquals($result, $result);
    }
}
