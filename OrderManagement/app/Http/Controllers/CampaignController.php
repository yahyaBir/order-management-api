<?php

namespace App\Http\Controllers;

use App\Services\CampaignService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }
    public function index(){
        $campaignResults = $this->campaignService->applyCampaigns();
        return response($campaignResults, 200);
    }
}
