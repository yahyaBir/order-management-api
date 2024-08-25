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
        $this->middleware('auth');
        $this->middleware('is_admin')->only(['store']);
    }

    public function index()
    {
        $campaigns = Campaign::paginate(20);

        if ($campaigns->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bulunan sonuç sayfasında kampanya bulunamadı.',
            ], 404);
        } else {
            $campaignData = $campaigns->map(function ($campaign) {
                return [
                    'title' => $campaign->title,
                    'type' => $campaign->type,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $campaignData,
                'total' => $campaigns->total(),
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:discount_for_author_origin,discount_for_amount,b2g1_author_cat,b3g1_selected_cat',
            'value' => 'nullable|numeric|min:0',
            'discount_threshold' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'author_id' => 'nullable|exists:authors,id',
            'author_origin_for_campaign' => 'nullable|in:foreign,local', // Eklenen kural
        ];

        $validated = $request->validate($rules);

        switch ($validated['type']) {
            case 'b2g1_author_cat':
                $additionalRules = [
                    'category_id' => 'required|exists:categories,id',
                    'author_id' => 'required|exists:authors,id',
                    'discount_threshold' => 'prohibited',
                    'value' => 'prohibited',
                    'author_origin_for_campaign' => 'prohibited',
                ];
                break;
            case 'b3g1_selected_cat':
                $additionalRules = [
                    'category_id' => 'required|exists:categories,id',
                    'discount_threshold' => 'prohibited',
                    'author_id' => 'prohibited',
                    'value' => 'prohibited',
                    'author_origin_for_campaign' => 'prohibited',
                ];
                break;
            case 'discount_for_amount':
                $additionalRules = [
                    'discount_threshold' => 'required|numeric|min:0',
                    'value' => 'required|numeric|min:1',
                    'category_id' => 'prohibited',
                    'author_id' => 'prohibited',
                    'author_origin_for_campaign' => 'prohibited',
                ];
                break;
            case 'discount_for_author_origin':
                $additionalRules = [
                    'author_origin_for_campaign' => 'required|in:foreign,local',
                    'discount_threshold' => 'prohibited',
                    'category_id' => 'prohibited',
                    'author_id' => 'prohibited',
                ];
                break;
            default:
                $additionalRules = [];
                break;
        }

        $validated = $request->validate(array_merge($rules, $additionalRules));

        $campaign = $this->campaignService->createCampaign($validated);

        return response()->json([
            'message' => 'Campaign created successfully.',
            'campaign' => $campaign
        ], 201);
    }
}
