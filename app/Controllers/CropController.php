<?php

namespace App\Controllers;

class CropController extends BaseController
{
    protected array $crops;
    protected string $lastUpdated;

    public function __construct()
    {
        $this->lastUpdated = "2 July 2025"; 
        $this->date_of_Data = "27 June 2025";

       $rawCrops = [
            "Pulses" => [
                ["name" => "Arhar",        "area" => 8.35, "last_year" => 8.67, "normal" => 44.71],
                ["name" => "Urdbean",      "area" => 2.35, "last_year" => 1.42, "normal" => 32.64],
                ["name" => "Moongbean",    "area" => 8.58, "last_year" => 4.30, "normal" => 35.69],
                ["name" => "Kulthi",       "area" => 0.09, "last_year" => 0.07, "normal" => 1.72],
                ["name" => "Mothbean",     "area" => 0.56, "last_year" => 0.01, "normal" => 9.70],
                ["name" => "Other pulses", "area" => 1.17, "last_year" => 0.89, "normal" => 5.15]
            ],

            "Cereals" => [
                ["name" => "Rice",          "area" => 35.02, "last_year" => 23.78, "normal" => 403.09],
                ["name" => "Jowar",         "area" => 2.70,  "last_year" => 1.53, "normal" => 15.07],
                ["name" => "Bajra",         "area" => 14.76,  "last_year" => 10.40, "normal" => 70.69],
                ["name" => "Ragi",          "area" => 0.08,  "last_year" => 0.91, "normal" => 11.52],
                ["name" => "Small millets", "area" => 0.53,  "last_year" => 0.82, "normal" => 4.48],
                ["name" => "Maize",         "area" => 23.69, "last_year" => 21.35, "normal" => 78.95]
            ],

            "Oilseeds" => [
                ["name" => "Groundnut",      "area" => 15.79, "last_year" => 8.14, "normal" => 45.10],
                ["name" => "Soybean",        "area" => 32.04, "last_year" => 31.78, "normal" => 127.19],
                ["name" => "Sunflower",      "area" => 0.39, "last_year" => 0.37, "normal" => 1.29],
                ["name" => "Sesamum",        "area" => 0.69, "last_year" => 0.43, "normal" => 10.32],
                ["name" => "Castor",         "area" => 0.04, "last_year" => 0.06, "normal" => 9.65],
                ["name" => "Other Oilseeds", "area" => 0.04, "last_year" => 0.04, "normal" => 0.00]
            ],

            "Commercial" => [
                ["name" => "Sugarcane",     "area" => 55.16, "last_year" => 54.88, "normal" => 52.51],
                ["name" => "Cotton",        "area" => 54.66, "last_year" => 59.97, "normal" => 129.50],
                ["name" => "Jute & Mesta",  "area" => 5.47,  "last_year" => 5.62,  "normal" => 6.59]
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
