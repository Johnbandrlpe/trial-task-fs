<?php

function loadFontFamilyFromTheme($jsonFilePath) {
    // Read JSON data from the file
    $jsonFile = file_get_contents($jsonFilePath);

    if ($jsonFile === false) {
        // Handle file read error
        return "Error reading JSON file";
    }

    $themeData = json_decode($jsonFile, true);

    if (isset($themeData['typography']['font'])) {
        $fontFaces = '';

        $fontPath = 'assets/fonts/'; // Change this path to match your directory structure

        foreach ($themeData['typography']['font']['variants'] as $variant) {
            $variantType = $variant['type'];
            $variantWeight = $variant['weight'];

            $fontFile = $fontPath . $themeData['typography']['font']['family'] . '-' . $variantType . '.ttf';

            $fontFaces .= "
                @font-face {
                    font-family: '{$themeData['typography']['font']['family']}';
                    src: url('$fontFile');
                    font-weight: $variantWeight;
                    font-style: normal;
                }
            ";
        }


        return $fontFaces;
    }

    return false;
}

function theme_load_font_family() {
    $jsonFilePath = 'design-system/theme.json';
    $fontFaces = loadFontFamilyFromTheme($jsonFilePath);

    echo "<style>
            {$fontFaces}
        </style>
    ";
}

add_action( 'wp_head', 'theme_load_font_family' );