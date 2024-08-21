<?php

namespace App\Services;

use App\Models\Product;

class CampaignService
{
    public function applyBestCampaign($orderItems, $totalAmount)
    {
        $bestDiscount = 0;
        $bestCampaign = '';

        // Campaign 1: Buy 2 Get 1 Free for Sabahattin Ali's Roman books
        $sabahattinAliBooks = Product::where('author', 'Sabahattin Ali')
            ->whereHas('category', function ($query) {
                $query->where('category_title', 'Roman');
            })
            ->pluck('id');

        $eligibleItems = $orderItems->filter(function ($item) use ($sabahattinAliBooks) {
            return $sabahattinAliBooks->contains($item['product_id']);
        });

        $totalQuantity = $eligibleItems->sum('quantity');
        $discountAmount = 0;

        if ($totalQuantity >= 2) {
            // Bedava kitap için en düşük fiyatlı ürünleri seçmek
            $prices = $eligibleItems->sortBy('price')->pluck('price');

            // Kampanya gereği sadece 1 bedava kitap olacağı için
            $discountAmount = $prices->first(); // En düşük fiyatlı ürünü seç

            if ($discountAmount > $bestDiscount) {
                $bestDiscount = $discountAmount;
                $bestCampaign = '2 al, 1 bedava (Sabahattin Ali Roman)';
            }
        }

        // Campaign 2: 5% Discount for Orders Over 200 TL
        if ($totalAmount > 200) {
            $discountAmount = $totalAmount * 0.05;
            if ($discountAmount > $bestDiscount) {
                $bestDiscount = $discountAmount;
                $bestCampaign = '5% Discount on Orders Over 200 TL';
            }
        }

        // Campaign 3: 5% Discount for Local Authors
        $localAuthorItems = $orderItems->filter(function ($item) {
            return $item->product->author_origin === 'local';
        });

        $localAuthorAmount = $localAuthorItems->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $discountAmount = $localAuthorAmount * 0.05;
        if ($discountAmount > $bestDiscount) {
            $bestDiscount = $discountAmount;
            $bestCampaign = '5% Discount for Local Authors';
        }

        // Return the best discount and campaign name
        return [
            'discountedAmount' => $totalAmount - $bestDiscount,
            'discount' => $bestDiscount,
            'appliedCampaign' => $bestCampaign,
        ];
    }
}


