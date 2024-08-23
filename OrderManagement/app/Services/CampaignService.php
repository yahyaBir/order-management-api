<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Campaign;
use http\Exception;
use Illuminate\Support\Collection;

class CampaignService
{
    public function applyBestCampaign(Collection $orderItems, float $orderAmount): array
    {
        $bestDiscount = 0;
        $bestCampaign = null;

        $campaigns = Campaign::all();
        $appliedCampaign = false;

        foreach ($campaigns as $campaign) {
            switch ($campaign->type) {
                case 'buy_one_get_one':
                    $sabahattinAliBooks = Product::where('author_id', 3)
                        ->where('category_id', $campaign->category_id)
                        ->pluck('id');

                    $filteredItems = $orderItems->filter(function ($item) use ($sabahattinAliBooks) {
                        return $sabahattinAliBooks->contains($item->product_id);
                    });

                    $totalQuantity = $filteredItems->sum('quantity');
                    if ($totalQuantity >= 2) {
                        $prices = $filteredItems->sortBy('price')->pluck('price');
                        $discountAmount = $prices->first();

                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                            $appliedCampaign = true;
                        }
                    }
                    break;

                case 'discount_for_item':
                    $allLocalAuthors = $orderItems->every(function ($item) {
                        return $item->product->author->author_origin === 'local';
                    });

                    if ($allLocalAuthors && $campaign->value == 5 && $campaign->discount_thresold == null) {
                        $discountAmount = $orderAmount * 0.05;
                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                            $appliedCampaign = true;
                        }
                    }
                    break;
                case 'discount_for_amount':
                    if ($orderAmount >= 200) {
                        $discountAmount = $orderAmount * ($campaign->value / 100);
                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                            $appliedCampaign = true;
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        return [
            'discountedAmount' => $appliedCampaign ? $orderAmount - $bestDiscount : $orderAmount,
            'discount' => $appliedCampaign ? $bestDiscount : 0,
            'appliedCampaign' => $bestCampaign,
        ];
    }
}
