<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Services\CampaignService;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }
    public function index()
    {
        $campaign = Campaign::paginate(20);

        if ($campaign->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bulunan sonuç sayfasında kampanya bulunamadı.',
            ], 404);
        } else {
            $campaignData = $campaign->map(function ($campaign) {
                return [
                    'title' => $campaign->title,
                    'type' => $campaign->type,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $campaignData,
                'total' => $campaign->total(),
            ], 200);
        }
    }
}
