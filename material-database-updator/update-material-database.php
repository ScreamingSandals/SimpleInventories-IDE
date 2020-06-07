<?php

require __DIR__ . '/vendor/autoload.php';

\Tracy\Debugger::enable();

function get_web_page( $url )
{
    $user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';

    $options = array(

        CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
        CURLOPT_POST           =>false,        //set to GET
        CURLOPT_USERAGENT      => $user_agent, //set user agent
        CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
        CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}

$payload = get_web_page("https://hub.spigotmc.org/javadocs/spigot/org/bukkit/Material.html")['content'];

phpQuery::newDocument($payload);

$materials = [];

$special_img_mappings = [
    'ATTACHED_MELON_STEM' => 'Attached_Stem',
    'ATTACHED_PUMPKIN_STEM' => 'Attached_Stem',
    'BAMBOO' => 'Leafless_Bamboo',
    'BEEF' => 'Raw_Beef',
    'CAVE_AIR' => 'Air',
    'CLAY' => 'Clay_Block',
    'CLAY_BALL' => 'Clay',
    'COMMAND_BLOCK' => 'Impulse_Command_Block',
    'COMPARATOR' => 'Redstone_Comparator_(Item)',
    'COOKED_BEEF' => 'Steak',
    'DRAGON_BREATH' => 'Dragon%27s_Breath',
    'EXPERIENCE_BOTTLE' => 'Bottle_o%27_Enchanting',
    'MAP' => 'Empty_Map',
    'FILLED_MAP' => 'Map_(Item)',
    'FROSTED_ICE' => 'Frosted_Ice_1',
    'HAY_BLOCK' => 'Hay_Bale_Axis_Y',
    'KELP_PLANT' => 'Kelp_(Item)',
    'LEATHER_CHESTPLATE' => 'Leather_Tunic',
    'LEATHER_HELMET' => 'Leather_Cap',
    'LEATHER_LEGGINGS' => 'Leather_Pants',
    'MELON_STEM' => 'Attached_Stem',
    'MOVING_PISTON' => 'Piston_BE',
    'MUTTON' => 'Raw_Mutton',
    'PORKCHOP' => 'Raw_Porkchop',
    'PUMPKIN_STEM' => 'Attached_Stem',
    'QUARTZ' => 'Nether_Quartz',
    'RABBIT' => 'Raw_Rabbit',
    'RABBIT_FOOT' => 'Rabbit%27s_Foot',
    'REDSTONE' => 'Redstone_Dust',
    'REDSTONE_WIRE' => 'Inactive_Redstone_Wire_(NS)',
    'REPEATER' => 'Redstone_Repeater_(Item)',
    'SLIME_BALL' => 'Slimeball',
    'TIPPED_ARROW' => 'Arrow_of_Weakness_Revision_1',
    'TURTLE_HELMET' => 'Turtle_Shell_(Item)',
    'VINE' => 'Vines',
    'VOID_AIR' => 'Air',
    'WRITABLE_BOOK' => 'Book_and_Quill',
    'LAPIS_BLOCK' => 'Lapis_Lazuli_Block',
    'LAPIS_ORE' => 'Lapis_Lazuli_Ore'
];


foreach (pq('code > span > a') as $element) {
    $name = pq($element)->text();
    if (strtoupper($name) == $name && substr($name, 0, 7) != "LEGACY_") {
        $img_name = str_replace([' ', '_And_', '_Of_', '_On_', '_A_', 'O_Lantern', 'Tnt', '_The_', 'Infested_'], ['_', '_and_', '_of_', '_on_', '_a_', 'o%27Lantern', 'TNT', '_the_', ''], ucwords(str_replace('_', ' ', strtolower($name))));

        $possible_img_names = [];
        if (isset($special_img_mappings[$name])) {
            $possible_img_names[] = $special_img_mappings[$name];
        }
        $possible_img_names[] = $img_name;
        $possible_img_names[] = $img_name . '_Block';          
        if (strpos($img_name, "_Block")) {
            $possible_img_names[] = "Block_of_" . substr($img_name, 0, strlen($img_name) - 6);
        }
        if (strpos($img_name, "_Minecart")) {
            $possible_img_names[] = "Minecart_with_" . substr($img_name, 0, strlen($img_name) - 9);
        }
        if (strpos($img_name, "_Bucket")) {
            $possible_img_names[] = "Bucket_of_" . substr($img_name, 0, strlen($img_name) - 7);
        }
        if (strpos($img_name, "Banner_Pattern")) {
            $possible_img_names[] = "Banner_Pattern";
        }
        if (strpos($img_name, "_Wall_")) {
            $possible_img_names[] = str_replace('_Wall_', '_', $img_name);
        }

        reset($possible_img_names);
        do {
            $img_payload = get_web_page("https://minecraft.gamepedia.com/File:" . current($possible_img_names) . ".png")['content'];
        } while (strpos($img_payload, "No file by this name exists.") && next($possible_img_names));

        if (strpos($img_payload, "No file by this name exists.")) {
            reset($possible_img_names);
            do {
                $img_payload = get_web_page("https://minecraft.gamepedia.com/File:" . current($possible_img_names) . ".gif")['content'];
            } while (strpos($img_payload, "No file by this name exists.") && next($possible_img_names));
        }

        phpQuery::newDocument($img_payload);
        $src = pq('.fullMedia > p > a.internal')->attr('href');
        $materials[$name] = [
                "link" => $src,
                "name" => str_replace([' And ', ' Of ', ' On ', ' A ', 'O Lantern', 'Tnt', ' The '], [' and ', ' of ', ' on ', ' a ', 'o\'Lantern', 'TNT', ' the '], ucwords(str_replace('_', ' ', strtolower($name))))
            ];
        if (!$src) {
            echo $name . "\n";
        }
        //echo "<img src='$src' width='20'>" . $name . "<br>";
    }
}

file_put_contents(__DIR__ . 'material.json', json_encode($materials));
