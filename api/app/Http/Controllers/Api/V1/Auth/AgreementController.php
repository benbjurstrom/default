<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Services\TermsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param TermsService $ts
     * @return \Illuminate\Http\Response
     */
    public function index(TermsService $ts)
    {
        $terms   = $ts->getTermsAgreement();
        $privacy = $ts->getPrivacyAgreement();

        return response()->json(compact('terms', 'privacy'));
    }
}
