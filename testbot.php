<?php
// Load composer

require __DIR__ . '/vendor/autoload.php';
use Longman\TelegramBot;

$bot_api_key = '374221474:AAEZ5B68ux8WJP4vC_phGBeA_VcgyzNQcto';
$bot_username = '@mjtestphp_bot';

try {
    // Create Telegram API object
    $telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
    $telegram->enableLimiter();

    $content = file_get_contents("php://input");
    $update = json_decode($content,TRUE);
    $chat_id = $update["message"]["chat"]["id"];

    checkJSON($chat_id,$update);

    if(!is_null($update["message"]["text"]))
    {
        $text = $update["message"]["text"];
        if(strpos($text,"/start") === 0)
        {
            $result = TelegramBot\Request::sendMessage(['chat_id' => $chat_id,'text'=> "درود"]);
            $response = API_URL. "/sendMessage?chat_id=" . $chat_id . "&text=" . "hi";
            file_get_contents($response);
        }
        else if($text === "سلام"){
            $result = TelegramBot\Request::sendMessage(['chat_id' => $chat_id,'text'=> "چطوری؟"]);
        }

    }
/*    else if(!is_null($update["message"]["document"]))
    {
        $file_id = print_r($update["message"]["document"]["file_id"]);
        $result = TelegramBot\Request::sendMessage(['chat_id' => $chat_id,'text'=> "file id = ". $file_id]);
    }*/


    function checkJSON($chat_id,$update){
        $myFile = "log.txt";
        $updateArray = print_r($update,TRUE);
        $fh = fopen($myFile,'a') or die("can't open file !");
        fwrite($fh, $chat_id ."\n\n");
        fwrite($fh, $updateArray."\n\n");
        fclose($fh);
    }
    $telegram->handle();
} catch (TelegramBot\Exception\TelegramException $e) {
    //
}