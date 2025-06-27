<?php

namespace App\Controllers;

class CropController extends BaseController
{
    protected array $crops;
    protected string $lastUpdated;

    public function __construct()
    {
        $this->lastUpdated = "27 June 2025"; 
        $this->date_of_Data = "20 June 2025";

       $rawCrops = [
            "Pulses" => [
                ["name" => "Arhar",        "area" => 2.48, "last_year" => 2.61, "normal" => 44.71],
                ["name" => "Urdbean",      "area" => 1.39, "last_year" => 0.62, "normal" => 32.64],
                ["name" => "Moongbean",    "area" => 4.43, "last_year" => 2.67, "normal" => 35.69],
                ["name" => "Kulthi",       "area" => 0.08, "last_year" => 0.07, "normal" => 1.72],
                ["name" => "Mothbean",     "area" => 0.11, "last_year" => 0.00, "normal" => 9.70],
                ["name" => "Other pulses", "area" => 0.94, "last_year" => 0.67, "normal" => 5.15]
            ],

            "Cereals" => [
                ["name" => "Rice",          "area" => 13.22, "last_year" => 8.37, "normal" => 403.09],
                ["name" => "Jowar",         "area" => 1.51,  "last_year" => 0.90, "normal" => 15.07],
                ["name" => "Bajra",         "area" => 3.70,  "last_year" => 2.71, "normal" => 70.69],
                ["name" => "Ragi",          "area" => 0.03,  "last_year" => 0.32, "normal" => 11.52],
                ["name" => "Small millets", "area" => 0.47,  "last_year" => 0.55, "normal" => 4.48],
                ["name" => "Maize",         "area" => 12.32, "last_year" => 10.31, "normal" => 78.95]
            ],

            "Oilseeds" => [
                ["name" => "Groundnut",      "area" => 1.78, "last_year" => 1.91, "normal" => 45.10],
                ["name" => "Soybean",        "area" => 3.07, "last_year" => 3.12, "normal" => 127.19],
                ["name" => "Sunflower",      "area" => 0.27, "last_year" => 0.26, "normal" => 1.29],
                ["name" => "Sesamum",        "area" => 0.20, "last_year" => 0.14, "normal" => 10.32],
                ["name" => "Castor",         "area" => 0.01, "last_year" => 0.02, "normal" => 9.65],
                ["name" => "Other Oilseeds", "area" => 0.03, "last_year" => 0.04, "normal" => 0.00]
            ],

            "Commercial" => [
                ["name" => "Sugarcane",     "area" => 55.07, "last_year" => 54.88, "normal" => 52.51],
                ["name" => "Cotton",        "area" => 31.25, "last_year" => 29.12, "normal" => 129.50],
                ["name" => "Jute & Mesta",  "area" => 5.46,  "last_year" => 5.62,  "normal" => 6.59]
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
                
                $crop['percentSown'] = $crop['normal'] > 0 ? round(($crop['area']/$crop['normal']) * 100, 2) : 0;

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
            'data_date' => $this->date_of_Data,
        ]);
    }

    
}
