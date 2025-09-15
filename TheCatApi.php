<?php

echo "🔄 Iniciando script... \n";

require_once 'credentials.php';

// Function to execute http request in php :)
function ejecutarSolicitudHttp($url, $metodo, $headers = [])
{
    try {
        // Init curl
        $ch = curl_init();

        // Config curl
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute request
        $resultado = curl_exec($ch);

        // Verify errors
        if ($resultado === false) {
            throw new Exception('Error cURL: ' . curl_error($ch));
        }

        // Get HTTP response code
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode >= 400) {
            throw new Exception("Error HTTP: code {$httpCode}");
        }

        curl_close($ch);

        // Decode JSON response
        $resultadoDecodificado = json_decode($resultado, true);
        if ($resultadoDecodificado === null) {
            throw new Exception("Error decoding JSON: " . json_last_error_msg());
        }

        return $resultadoDecodificado;
    } catch (Exception $e) {
        echo "Error in request to {$url}: " . $e->getMessage() . "\n";
        return null;
    }
}

// This is the public API URL, if you want use this api, you're free to use it
$apiURL = 'https://api.thecatapi.com/v1/';

// Endpoint
$endpoint = 'images/search';

// Parameters, in this case, we're getting a random cat image and the breed of the cat
$params = '?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=1';

// Complete url
$url = $apiURL . $endpoint . $params;

// Headers, in this case, we're using the api key to get the data
$headers = [
    'Content-Type: application/json',
    'x-api-key: '. API_KEY
];

for ($i = 0; $i < 25; $i++) {
    $response = ejecutarSolicitudHttp($url, 'GET', $headers);

    if ($response) {
        break;
    }

    if ($i == 24) {
        // Unfortunately, the api is down
        echo "API is currently unavailable\n";
        exit(1);
    }
}

$data = $response[0];

$imageUrl = isset($data['url']) ? $data['url'] : 'https://via.placeholder.com/400x300?text=No+Image';
$imageId = isset($data['id']) ? $data['id'] : 'unknown';
$imageWidth = isset($data['width']) ? $data['width'] : 'unknown';
$imageHeight = isset($data['height']) ? $data['height'] : 'unknown';

$breed = isset($data['breeds']) ? $data['breeds'] : false;

// Set default values
$breedName = 'Mixed Breed';
$temperament = 'Playful and curious';
$origin = 'Unknown';
$description = 'A beautiful cat with a unique personality!';
$lifeSpan = '12-18 years';
$wikipediaUrl = '';
$altNames = '';
$adaptability = 'Unknown';
$affectionLevel = 'Unknown';
$childFriendly = 'Unknown';
$dogFriendly = 'Unknown';
$energyLevel = 'Unknown';
$grooming = 'Unknown';
$healthIssues = 'Unknown';
$intelligence = 'Unknown';
$sheddingLevel = 'Unknown';
$socialNeeds = 'Unknown';
$strangerFriendly = 'Unknown';
$vocalisation = 'Unknown';
$experimental = 'No';
$hairless = 'No';
$natural = 'Yes';
$rare = 'No';
$rex = 'No';
$suppressedTail = 'No';
$shortLegs = 'No';
$hypoallergenic = 'No';

if ($breed && count($breed) > 0) {
    $breedData = $breed[0];
    $breedName = isset($breedData['name']) ? $breedData['name'] : $breedName;
    $temperament = isset($breedData['temperament']) ? $breedData['temperament'] : $temperament;
    $origin = isset($breedData['origin']) ? $breedData['origin'] : $origin;
    $description = isset($breedData['description']) ? $breedData['description'] : $description;
    $lifeSpan = isset($breedData['life_span']) ? $breedData['life_span'] . ' years' : $lifeSpan;
    $wikipediaUrl = isset($breedData['wikipedia_url']) ? $breedData['wikipedia_url'] : '';
    $altNames = isset($breedData['alt_names']) ? $breedData['alt_names'] : '';

    // Additional breed characteristics
    $adaptability = isset($breedData['adaptability']) ? str_repeat('⭐', $breedData['adaptability']) : $adaptability;
    $affectionLevel = isset($breedData['affection_level']) ? str_repeat('❤️', $breedData['affection_level']) : $affectionLevel;
    $childFriendly = isset($breedData['child_friendly']) ? str_repeat('👶', $breedData['child_friendly']) : $childFriendly;
    $dogFriendly = isset($breedData['dog_friendly']) ? str_repeat('🐕', $breedData['dog_friendly']) : $dogFriendly;
    $energyLevel = isset($breedData['energy_level']) ? str_repeat('⚡', $breedData['energy_level']) : $energyLevel;
    $grooming = isset($breedData['grooming']) ? str_repeat('✂️', $breedData['grooming']) : $grooming;
    $healthIssues = isset($breedData['health_issues']) ? str_repeat('🏥', $breedData['health_issues']) : $healthIssues;
    $intelligence = isset($breedData['intelligence']) ? str_repeat('🧠', $breedData['intelligence']) : $intelligence;
    $sheddingLevel = isset($breedData['shedding_level']) ? str_repeat('🪶', $breedData['shedding_level']) : $sheddingLevel;
    $socialNeeds = isset($breedData['social_needs']) ? str_repeat('👥', $breedData['social_needs']) : $socialNeeds;
    $strangerFriendly = isset($breedData['stranger_friendly']) ? str_repeat('🤝', $breedData['stranger_friendly']) : $strangerFriendly;
    $vocalisation = isset($breedData['vocalisation']) ? str_repeat('🗣️', $breedData['vocalisation']) : $vocalisation;

    // Boolean characteristics
    $experimental = isset($breedData['experimental']) && $breedData['experimental'] ? 'Yes 🧪' : 'No';
    $hairless = isset($breedData['hairless']) && $breedData['hairless'] ? 'Yes 🦲' : 'No';
    $natural = isset($breedData['natural']) && $breedData['natural'] ? 'Yes 🌿' : 'No';
    $rare = isset($breedData['rare']) && $breedData['rare'] ? 'Yes 💎' : 'No';
    $rex = isset($breedData['rex']) && $breedData['rex'] ? 'Yes 🌀' : 'No';
    $suppressedTail = isset($breedData['suppressed_tail']) && $breedData['suppressed_tail'] ? 'Yes' : 'No';
    $shortLegs = isset($breedData['short_legs']) && $breedData['short_legs'] ? 'Yes 🦵' : 'No';
    $hypoallergenic = isset($breedData['hypoallergenic']) && $breedData['hypoallergenic'] ? 'Yes 🌿' : 'No';
}

// Chance
if (file_exists("README.md")) {
    unlink("README.md"); // Delete the file for detect a change.
}

$year = date("Y");
$month = date("M");
$day = date("d");
$fullDate = date("F j, Y");
$time = date("H:i:s");

$readme_template = <<<EOT
# 🐱 Daily Cat Feature - Random Cat Breeds Discovery 🎯

> **An automated script that fetches and showcases beautiful cats daily!**  
> Every day, we discover a new random cat with detailed breed information from The Cat API.  
> Each update brings you closer to the wonderful world of felines! 🐾

---

## 🌟 Today's Featured Cat
> ✨ **Updated:** `$fullDate at $time`  
> 🆔 **Cat ID:** `$imageId`  
> 📐 **Image Dimensions:** `{$imageWidth}x{$imageHeight}px`

### 🖼️ Meet Today's Star!

<div align="center">
  <img src="$imageUrl" alt="$breedName Cat" width="500" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
</div>

---

## 📋 Breed Information

### 🏷️ **$breedName**
EOT;

if ($altNames) {
    $readme_template .= "\n> *Also known as: $altNames*\n";
}

$readme_template .= <<<EOT

**📍 Origin:** $origin  
**⏳ Life Span:** $lifeSpan  
**🧬 Temperament:** $temperament  

### 📖 Description
> $description

---

## 📊 Breed Characteristics

| Characteristic | Rating | Characteristic | Rating |
|---|---|---|---|
| 🏠 **Adaptability** | $adaptability | 🧠 **Intelligence** | $intelligence |
| ❤️ **Affection Level** | $affectionLevel | 🪶 **Shedding Level** | $sheddingLevel |
| 👶 **Child Friendly** | $childFriendly | 👥 **Social Needs** | $socialNeeds |
| 🐕 **Dog Friendly** | $dogFriendly | 🤝 **Stranger Friendly** | $strangerFriendly |
| ⚡ **Energy Level** | $energyLevel | 🗣️ **Vocalisation** | $vocalisation |
| ✂️ **Grooming Needs** | $grooming | 🏥 **Health Issues** | $healthIssues |

---

## 🧬 Special Traits

| Trait | Status | Trait | Status |
|---|---|---|---|
| 🧪 **Experimental** | $experimental | 💎 **Rare Breed** | $rare |
| 🦲 **Hairless** | $hairless | 🌀 **Rex Coat** | $rex |
| 🌿 **Natural Breed** | $natural | 🦵 **Short Legs** | $shortLegs |
| 🌿 **Hypoallergenic** | $hypoallergenic | 🐾 **Suppressed Tail** | $suppressedTail |

---
EOT;

if ($wikipediaUrl) {
    $readme_template .= <<<EOT

## 📚 Learn More
🔗 **[Read more about $breedName on Wikipedia]($wikipediaUrl)**

---
EOT;
}

$readme_template .= <<<EOT

## 🚀 How It Works

1. 📅 **Daily Schedule**: Script runs automatically every day
2. 🌐 **API Call**: Fetches random cat data from [The Cat API](https://thecatapi.com/)
3. 🔄 **Data Processing**: Extracts breed information and characteristics  
4. 📝 **README Update**: Generates this beautiful documentation
5. 🔄 **Git Commit**: Automatically pushes changes to repository

---

## 🛠️ Technical Details

```php
// API Endpoint Used
https://api.thecatapi.com/v1/images/search?size=med&mime_types=jpg&format=json&has_breeds=true&order=RANDOM&page=0&limit=1
```

### 📋 Features
- ✅ **Random cat selection** with breed information
- ✅ **Comprehensive breed characteristics** with emoji ratings
- ✅ **High-quality images** (medium size, JPG format)
- ✅ **Automatic daily updates** via GitHub Actions
- ✅ **Responsive design** with beautiful formatting
- ✅ **Error handling** and retry mechanisms

---

## 🏆 Statistics

- 📸 **Total Images Processed:** `Updated daily`
- 🐱 **Breeds Discovered:** `Growing collection`  
- 📅 **Days Active:** `Since repository creation`
- 🔄 **Last Update:** `$fullDate`

---

## 🌐 API Credits

This project uses **[The Cat API](https://thecatapi.com/)** - A public API for cat lovers!  
- 🆓 **Free to use**
- 📸 **High-quality images**
- 📊 **Comprehensive breed data**
- 🌍 **Worldwide cat breeds**

---

## 💝 Support This Project

If you love cats and this project, consider:

- ⭐ **Star this repository**
- 🍴 **Fork and contribute**
- 🐛 **Report issues**
- 💡 **Suggest improvements**
- 🐱 **Share with fellow cat lovers**

---

<div align="center">
  <h3>🐾 Made with ❤️ for Rafael Solis. 🐾</h3>
  <p><em>I hope you like it! Muejeje</em></p>
  
  <img src="https://media.giphy.com/media/JIX9t2j0ZTN9S/giphy.gif" width="200" alt="Cat GIF">
</div>

---

*📝 This README is automatically generated daily using PHP and The Cat API*  
*🔄 Next update: Tomorrow at the same time*  
*📧 Questions? Feel free to open an issue!*
EOT;

// Force change in the README with a hidden timestamp comment
$readme_template .= "\n\n<!-- Generated automatically on " . date('Y-m-d H:i:s T') . " | Image ID: $imageId -->";

file_put_contents("README.md", $readme_template);

echo "✅ README.md successfully generated with cat: $breedName\n";
echo "🖼️ Image URL: $imageUrl\n";
echo "📅 Generated on: $fullDate at $time\n";

exec("git status --porcelain", $output);

if (!empty($output)) {
    echo "📌 Changes detected in Git. Proceeding with the commit...\n";
    
    exec('git config user.name "'. USER_NAME .'"');
    exec('git config user.email "'. USER_EMAIL .'"');
    exec("git add -A");
    exec("git commit -m \"Update ApiCat - $year-$month-$day\" 2>&1", $commit_output);

    echo implode("\n", $commit_output) . "\n";
    echo "Commit:\n" . implode("\n", $commit_output) . "\n";


    // Upload changes to GitHub
    echo "🚀 Uploading changes to GitHub...\n";
    
    exec("git config --local pack.threads 1");
    exec("git config --local pack.windowMemory 10m");
    exec("git config --local pack.packSizeLimit 20m");
    
    $gc_log = __DIR__ . '/.git/gc.log';
    if (file_exists($gc_log)) {
        unlink($gc_log);
    }

    exec("git remote set-url origin https://". ENV_GITHUB_TOKEN ."@github.com/". ENV_GITHUB_REPO .".git");

    exec("git push --force origin main 2>&1", $push_output);
    echo implode("\n", $push_output) . "\n";

    echo "✅ README.md updated and uploaded correctly.\n";
    echo "Push:\n" . implode("\n", $push_output) . "\n";
    echo "✅ Push completed.\n";
} else {
    echo "⚠️ No changes in the holiday. No commit was made.\n";
}
echo "✅ Script finished.\n";