<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Campaign;
use Illuminate\Support\Collection;

class CampaignService
{
    public function applyBestCampaign(Collection $orderItems, float $totalAmount): array
    {
        $bestDiscount = 0;
        $bestCampaign = '';

        $campaigns = Campaign::all();

        foreach ($campaigns as $campaign) {
            switch ($campaign->type) {
                case 'buy_one_get_one':
                    $sabahattinAliBooks = Product::where('author_id', 3)
                    ->where('category_id', $campaign->category_id)
                        ->pluck('id');


                    $filteredItems = $orderItems->filter(function ($item) use ($sabahattinAliBooks) {
                        return $sabahattinAliBooks->contains($item['product_id']);
                    });

                    $totalQuantity = $filteredItems->sum('quantity');
                    if ($totalQuantity >= 2) {
                        $prices = $filteredItems->sortBy('price')->pluck('price');
                        $discountAmount = $prices->first(); // Apply the discount on the lowest priced book

                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                        }
                    }
                    break;

                case 'discount':
                    if ($totalAmount > $campaign->discount_threshold) {
                        $discountAmount = $totalAmount * ($campaign->value / 100);
                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                        }
                    }
                    break;

                default:
                    break;
            }
        }

        return [
            'discountedAmount' => $totalAmount - $bestDiscount,
            'discount' => $bestDiscount,
            'appliedCampaign' => $bestCampaign,
        ];
    }
}
