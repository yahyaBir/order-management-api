<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Campaign;
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
                case 'b2g1_author_cat':
                    // 'buy_two_get_one_author_categories' kampanya türü için
                    $selectedBooks = Product::where('author_id', $campaign->author_id)
                        ->where('category_id', $campaign->category_id)
                        ->pluck('id');

                    $filteredItems = $orderItems->filter(function ($item) use ($selectedBooks) {
                        return $selectedBooks->contains($item->product_id);
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

                case 'b3g1_selected_cat':
                    $filteredItems = $orderItems->filter(function ($item) use ($campaign) {
                        return $item->product->category_id == $campaign->category_id;
                    });

                    $totalQuantity = $filteredItems->sum('quantity');
                    if ($totalQuantity >= 3) {
                        $prices = $filteredItems->sortBy('price')->pluck('price');
                        $discountAmount = $prices->first();

                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                            $appliedCampaign = true;
                        }
                    }
                    break;

                case 'discount_for_author_origin':
                    // Kampanya için belirlenen author_origin
                    $authorOriginForCampaign = $campaign->author_origin_for_campaign;

                    // Order ile ilişkilendirilmiş ürünlerin yazar origin kontrolü
                    $allMatchingAuthors = $orderItems->every(function ($item) use ($authorOriginForCampaign) {
                        return $item->product->author->author_origin === $authorOriginForCampaign;
                    });

                    // Eğer tüm ürünler belirtilen author origin'e sahipse
                    if ($allMatchingAuthors && $campaign->discount_threshold == null) {
                        $discountAmount = $orderAmount * ($campaign->value / 100); // Örneğin %5 indirim
                        if ($discountAmount > $bestDiscount) {
                            $bestDiscount = $discountAmount;
                            $bestCampaign = $campaign->title;
                            $appliedCampaign = true;
                        }
                    }
                    break;

                case 'discount_for_amount':
                    // Sadece 'discount_for_amount' kampanya türüne sahip kampanyaların eşik değerini al
                    $thresholdCampaigns = $campaigns->filter(function ($campaign) {
                        return $campaign->type === 'discount_for_amount';
                    });

                    foreach ($thresholdCampaigns as $thresholdCampaign) {
                        $discountThreshold = $thresholdCampaign->discount_threshold;

                        if ($orderAmount >= $discountThreshold) {
                            $discountAmount = $orderAmount * ($thresholdCampaign->value / 100);

                            if ($discountAmount > $bestDiscount) {
                                $bestDiscount = $discountAmount;
                                $bestCampaign = $thresholdCampaign->title;
                                $appliedCampaign = true;
                            }
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

    public function createCampaign(array $validatedData)
    {
        // Yeni kampanyayı oluştur
        $campaign = new Campaign();
        $campaign->title = $validatedData['title'];
        $campaign->type = $validatedData['type'];
        $campaign->value = $validatedData['value'] ?? null;
        $campaign->discount_threshold = $validatedData['discount_threshold'] ?? null;
        $campaign->category_id = $validatedData['category_id'] ?? null;
        $campaign->author_id = $validatedData['author_id'] ?? null;
        $campaign->author_origin_for_campaign = $validatedData['author_origin_for_campaign'] ?? null;
        $campaign->save();

        return $campaign;
    }
}
