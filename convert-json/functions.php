<?php
// Read JSON data from the file
$jsonFile = file_get_contents('data/sample.json');

if ($jsonFile === false) {
    // Handle file read error
    return "Error reading JSON file";
}

// Decode JSON data
$data = json_decode($jsonFile, true);

// Organize the data based on the "level" attribute
$organizedData = [];

foreach ($data as $item) {
    $level = $item['attributes']['level'];

    $newItem = [
        "id" => $item['id'],
        "level" => $level
    ];

    if ($level === 1) {
        $organizedData[] = $newItem;
    } else {
        $lastIndex = count($organizedData) - 1;
        $currentLevel = &$organizedData[$lastIndex];

        for ($i = 1; $i < $level - 1; $i++) {
            $currentLevel = &$currentLevel['children'][count($currentLevel['children']) - 1];
        }

        $currentLevel['children'][] = $newItem;
    }
}

// Output the transformed data
echo json_encode($organizedData, JSON_PRETTY_PRINT);
