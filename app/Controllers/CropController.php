<?php

namespace App\Controllers;

class CropController extends BaseController
{
    protected array $crops;
    protected string $lastUpdated;

    public function __construct()
    {
        $this->lastUpdated = "13 June 2025"; // Ideally from dynamic source
        $this->prevDate = "13 June 2024";

        $rawCrops = [
            "Pulses" => [
                ["name" => "Tur", "area" => 0.30, "last_year" => 0.40, "advice" => "Demand likely to rise — monitor MSP"],
                ["name" => "Moong", "area" => 1.56, "last_year" => 1.21, "advice" => "Favorable rains — short duration crop"],
                ["name" => "Udid", "area" => 0.43, "last_year" => 0.39, "advice" => "Suits early sowing — low water need"]
            ],
            "Cereals" => [
                ["name" => "Rice", "area" => 4.53, "last_year" => 5.11, "advice" => "Rain-dependent — consider hybrid if low rainfall"],
                ["name" => "Maize", "area" => 3.60, "last_year" => 3.25, "advice" => "Dual purpose — feed + food"],
                ["name" => "Jowar", "area" => 1.01, "last_year" => 0.91, "advice" => "Suits dryland farmers"]
            ],
            "Oilseeds" => [
                ["name" => "Soybean", "area" => 1.07, "last_year" => 1.10, "advice" => "Risk of oversupply — diversify"],
                ["name" => "Groundnut", "area" => 3.00, "last_year" => 2.45, "advice" => "Good for rainfed zones"],
                ["name" => "Sesamum", "area" => 4.52, "last_year" => 4.60, "advice" => "Export friendly — niche market"]
            ]
        ];

        // Calculate diff, % change, trend
        $this->crops = [];
        foreach ($rawCrops as $category => $cropList) {
            foreach ($cropList as &$crop) {
                $diff = round($crop['area'] - $crop['last_year'], 2);
                $crop['diff'] = $diff;
                $crop['percent_change'] = ($crop['last_year'] > 0)
                    ? round(($diff / $crop['last_year']) * 100, 2)
                    : 0;
                $crop['trend'] = $diff > 0 ? '↑' : ($diff < 0 ? '↓' : '→');
            }
            $this->crops[$category] = $cropList;
        }
    }

    public function index(): string
    {
        return view('cropView/index', [
            'crops' => $this->crops,
            'last_updated' => $this->lastUpdated,
            'current_year' => 2025,
            'comparison_year' => 2024,
            'comparison_date' => $this->prevDate,
        ]);
    }
}
