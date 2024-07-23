<?php

return [

    'aqi_thresholds' => [
        /**
         * 
         * https://www.umweltbundesamt.de/en/topics/health/commissions-working-groups/german-committee-on-indoor-air-guide-values#undefined
         * https://www.ncbi.nlm.nih.gov/pmc/articles/PMC8627286/
         * https://www.umweltbundesamt.de/sites/default/files/medien/4031/bilder/dateien/0_hygienic_guide_values_20220704_en.pdf (German Guide for Co2, PM2.5)
         * Although carbon dioxide levels below 800 ppm were considered an indicator of adequate ventilation based on CDC recommendations
         */
        'co2' => 1000,
        'tvoc' => 1000,

        /**
         * https://www.epa.gov/mold/brief-guide-mold-moisture-and-your-home
         */
        'min_humidity' => 30,
        'max_humidity' => 60,

        /**
         * https://document.airnow.gov/technical-assistance-document-for-the-reporting-of-daily-air-quailty.pdf
         */
        'pm2_5' => 35.4,
        'pm10' => 154,
    ]
];
