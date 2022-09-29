<?php
include 'conn.php';  
ob_start();  
define('API_KEY','2006776430:AAE9MnoJLkz1TTHd37SnNKTqNuJjTXKQrns');

function bot($method,$datas=[]){  
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);  
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);  
    if(curl_error($ch)){  
        var_dump(curl_error($ch));  
    }else{  
        return json_decode($res);  
    }  
}  
$update = json_decode(file_get_contents('php://input'));
$message = $update->message; 
$mid = $message->message_id; 
$chat_id = $message->chat->id;  
$mtext = $message->text;
$doc=$message->document;
$doc_id=$doc->file_id;
$data = $update->callback_query->data;
$cid2 = $update->callback_query->message->chat->id;
$mid2 = $update->callback_query->message->message_id;
$step1=file_get_contents("qadam/$chat_id.step1");
$step = file_get_contents("aloqa/$chat_id.step"); 
$menyu = file_get_contents("aloqa/$chat_id.menyu");
$maqolachi_id = file_get_contents("aloqa/$chat_id.maqolachi_id");
mkdir("qadam");
mkdir("maqola");
mkdir("aloqa");
$adminId = "76576556";
$ism = 'ism'; 
$familiya = 'familiya';
$otasiningIsmi = 'otasiningIsmi';
$maqolaId = 'maqolaId';
$idmaqolachi = 'id';
$uchir1 = [
    'inline_keyboard' => [
        [
            ['text' => 'Ўчириш ❌', 'callback_data' => "uchir"]
        ]
    ]
];
$uchir = json_encode($uchir1); 
$qabul1 = [
    'inline_keyboard' => [
        [
            ['text' => 'Qabul qil', 'callback_data' => "qabul"],['text' => 'Qaytar', 'callback_data' => "qaytar"],
        ],
    ]
];
$qabul = json_encode($qabul1); 
$MaqolaYuborish1 = [
    'inline_keyboard' => [
        [
            ['text' => 'Янги мақола юбориш 📋', 'callback_data' => "MaqolaYuborish"]
        ]
    ]
];
$MaqolaYuborish = json_encode($MaqolaYuborish1);

$Yunalishlar1 = [
    'inline_keyboard' => [
        [
            ['text' => '05.00.00 - Техника фанлари', 'callback_data' => "texnika"],
        ],
        [
            ['text' => '13.00.00 - Педагогика фанлари', 'callback_data' => "pedagogika"],
        ],
       
    ]
];
$Yunalishlar = json_encode($Yunalishlar1);


$bekor = json_encode([  
'resize_keyboard'=>true,  
'keyboard'=>[  
[['text'=>"Bekor qilish 🙅‍♂️"],],   
]  
]);

$adminmenyu = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"Qabul qilingan maqolalar"]],
[['text'=>"Ishchi bazani tozalash"],['text'=>"Maqolani qabul qilish"]],
[['text'=>"Muallif bilan bog'lanish"]],
]
]);

if (($mtext != "/start") && ($mtext != "/maqola") && ($mtext != "/qabul") && ($mtext != "/boglanish") && ($chat_id != $adminId) && isset($mtext)) {
    bot('sendmessage',[   
   'chat_id'=>$adminId,   
   'text'=>$mtext."\n Idsi ".$chat_id,
]);
    }
  
if(($mtext == "/start") && ($chat_id == $adminId)) {    
  bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Assalomu alaykum!  admin!",
   'reply_markup'=>$adminmenyu,
]);  
} else{
    if($mtext == "/start" or $mtext == "/maqola"){

bot('sendphoto',[
'chat_id'=>$chat_id, 
'photo'=>new CURLFile("8.png"),
'caption'=>"Ҳурматли муаллифлар📣

✅ «Central Asian Journal of Education and Computer Sciences» илмий журналининг 2-сонига мақолалар қабул қилинмоқда. 

✅ Журналга қуйидаги йўналишлар бўйича мақолалар қабул қилинади:
05.00.00 - Техника фанлари,
13.00.00 - Педагогика фанлари (Информатикага оид),


✅ Мақолалар 2022 йил 28 апрель кунига қадар қабул қилинади. 

📜 Журналнинг 2-сони 2022 йил 30-апрель кунига қадар электрон кўринишда нашр этилади.

🖥 Журналдаги мақолалар Google Scholar, Research Bible, Index Copernicus, DOAJ, BASE, OpenAIRE, WorldCat ва бошқа шу каби тизимларда  индексланади.

✅ Мақолалар мамлакатимизда ушбу соҳада фаолият юритаётган етук академик, профессор ва олимлар кўриб чиқиб, маъқуллагандан кейин нашр қилинади. Шу сабабли салоҳиятли журнал ҳисобланади.

✅ CAJECS хусусий таҳририят.

Мақолаларингизни кутиб қоламиз!

Мурожаат учун 👇👇👇
🌏 https://cajecs.com
🌎 @cajecs_bot
✉️ https://t.me/cajecs",
]);

bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Сиз мақолани шу ердан юборинг. Таҳририятимиз Сиз билан ҳамкорликда мақолангиз мукаммал даражага келгунча ишлашади. Сўнгра нашрга қабул қилинади.\n Қуйидаги `Янги мақола юбориш 📋` Тугмасини босинг ва мақолани юборинг",
   'parse_mode'=>"markdown",
   'reply_markup'=>$MaqolaYuborish,
]);
unlink("qadam/$chat_id.step1");
}
}

if($data == "MaqolaYuborish"){
  bot('sendMessage',[ 
     'chat_id'=>$cid2, 
     'text'=>"Мақола юбориш учун қуйидаги йўналишлардан бирини танланг.", 
     'parse_mode'=>'markdown', 
     'reply_markup'=>$Yunalishlar,
]);
  bot('deleteMessage',[
    'chat_id'=>$cid2,
    'message_id'=>$mid2,
  ]);
}
if($data == "texnika"){
    bot('sendMessage',[ 
     'chat_id'=>$cid2, 
     'text'=>"Яхши. Сиз 05.00.00 - Техника фанлари йўналишини танладинггиз. Мақолани .doc ёки .docx форматларда юкланг", 
]);
file_put_contents("qadam/$cid2.step1", "texnika");
    bot('deleteMessage',[
        'chat_id'=>$cid2,
        'message_id'=>$mid2,
  ]);
}

 if($step1 == "texnika"){        
    if(isset($message->document) and $step1 == "texnika"){
        file_put_contents("maqola/$chat_id.maqola", $doc_id);
        $t=time();
        $a=file_get_contents("maqola/$chat_id.maqola");
    bot('senddocument',[   
        'chat_id'=>$adminId,   
        'document'=>$a, 
        'caption'=>"Ҳурматли админ Сизга ".$chat_id." ID адресли фойдалнувчи 05.00.00 - Техника фанлари йўналишига мақолани кўриб чиқиш учун юборди. ", 
        'reply_markup'=>$adminmenyu,
        ]);
    bazagayoz($chat_id, $a, $t);
    bot('sendmessage',[   
        'chat_id'=>$chat_id,   
        'text'=>"Бизни танлаганинггиз учун сизга миннадорчилик билдирамиз! 👏👏👏 Мақола кўриб чиқиш учун юборилди.👍 Таҳририят жамоаси мақолани кўриб чиққандан кейин шу бот орқали Сиз билан боғланишади. Админ ёки тақризчи билан боғланишни хохласангиз шу бот орқали ёзиб жўнатишингиз мумкин. Ишларинггиз омад тилаб қоламиз!",
        'reply_markup'=>$MaqolaYuborish,   
        ]);
    unlink("qadam/$chat_id.step1");
    unlink("maqola/$chat_id.maqola");
} }

if($data == "pedagogika"){
    bot('sendMessage',[ 
     'chat_id'=>$cid2, 
     'text'=>"Яхши. Сиз 13.00.00 - Педагогика фанлари йўналишини танладинггиз. Мақолани .doc ёки .docx форматларда юкланг", 
]);
file_put_contents("qadam/$cid2.step1", "pedagogika");
    bot('deleteMessage',[
        'chat_id'=>$cid2,
        'message_id'=>$mid2,
  ]);
}

 if($step1 == "pedagogika"){        
    if(isset($message->document) and $step1 == "pedagogika"){
        file_put_contents("maqola/$chat_id.maqola", $doc_id);
        $t=time();
        $a=file_get_contents("maqola/$chat_id.maqola");
    bot('senddocument',[   
        'chat_id'=>$adminId,   
        'document'=>$a, 
        'caption'=>"Ҳурматли админ Сизга ".$chat_id." ID адресли фойдалнувчи 05.00.00 - Техника фанлари йўналишига мақолани кўриб чиқиш учун юборди.", 
        'reply_markup'=>$adminmenyu,
        ]);
    bazagayoz($chat_id, $a, $t);
    bot('sendmessage',[   
        'chat_id'=>$chat_id,   
        'text'=>"Бизни танлаганинггиз учун сизга миннадорчилик билдирамиз! 👏👏👏 Мақола кўриб чиқиш учун юборилди.👍 Таҳририят жамоаси мақолани кўриб чиққандан кейин шу бот орқали Сиз билан боғланишади. Админ ёки тақризчи билан боғланишни хохласангиз шу бот орқали ёзиб жўнатишингиз мумкин. Ишларинггиз омад тилаб қоламиз!",
        'reply_markup'=>$MaqolaYuborish,   
        ]);
    unlink("qadam/$chat_id.step1");
    unlink("maqola/$chat_id.maqola");
} }

if($mtext == "/boglanish"){
    bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Масъул  шахс 🤵 билан боғланиш учун мурожаатингизни 👇 ёзиб юборинг.  Албатта Сиз билан 🔗 боғланишади.",
   ]);  
    unlink("qadam/$chat_id.step1");
}

if($mtext == "Maqolani qabul qilish" && $chat_id == $adminId){
  file_put_contents("aloqa/$chat_id.step","bir4");  
  file_put_contents("aloqa/$chat_id.menyu","mom4");
    bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Maxsus raqamni kiriting.",
   'reply_markup'=>$bekor,
    ]);  
}
if($step == "bir4" && $menyu == "mom4"){
  if($mtext == "Bekor qilish 🙅‍♂️"){        
  bot('sendmessage',[   
  'chat_id'=>$chat_id,   
  'text'=>"Bekor qilindi",   
  'parse_mode'=>"markdown",  
  'reply_markup'=>$adminmenyu,
  ]);
  unlink("aloqa/$chat_id.step"); 
  unlink("aloqa/$chat_id.menyu");  
}else{
    qabulqil($mtext);
    bot('sendmessage',[   
    'chat_id'=>$chat_id,   
    'text'=>"✅✅✅ Maqola qabul qilindi",   
    'reply_markup'=>$adminmenyu,
    ]);
    unlink("aloqa/$chat_id.step"); 
    unlink("aloqa/$chat_id.menyu");  
}
}



if($mtext == "Ishchi bazani tozalash" && $chat_id == $adminId){
  file_put_contents("aloqa/$chat_id.step","bir3");  
  file_put_contents("aloqa/$chat_id.menyu","mom3");
    bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Parolni kiriting.",
   'reply_markup'=>$bekor,
    ]);  
}
if($step == "bir3" && $menyu == "mom3"){
  if($mtext == "Bekor qilish 🙅‍♂️"){        
  bot('sendmessage',[   
  'chat_id'=>$chat_id,   
  'text'=>"Bekor qilindi",   
  'parse_mode'=>"markdown",  
  'reply_markup'=>$adminmenyu,
  ]);
  unlink("aloqa/$chat_id.step"); 
  unlink("aloqa/$chat_id.menyu");  
}else{
    if ($mtext=="Baza@1234") {
        udalitbaza();
        bot('sendmessage',[   
    'chat_id'=>$chat_id,   
    'text'=>'Baza tozalandi',   
    'parse_mode'=>"markdown",  
    'reply_markup'=>$adminmenyu,
    ]);
    unlink("aloqa/$chat_id.step"); 
    unlink("aloqa/$chat_id.menyu"); 
    } else{
         bot('sendmessage',[   
    'chat_id'=>$chat_id,   
    'text'=>'Parol xato!',   
    'parse_mode'=>"markdown",  
    'reply_markup'=>$adminmenyu,
    ]);
    unlink("aloqa/$chat_id.step"); 
    unlink("aloqa/$chat_id.menyu");     
    }
}
}

if($mtext == "Qabul qilingan maqolalar" && $chat_id == $adminId){
    $aaa=qabulQilinganMaqolalar();
    bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Quyidagi maqolalar qabul qilingan.",
    ]);

    for ($i=0; $i<count($aaa); $i++){

        if ($aaa[$i][2] == 1) {
            bot('senddocument',[   
                'chat_id'=>$chat_id,   
                'document'=>$aaa[$i][1],
                'caption'=>"✅✅✅ Maqola qabul qilingan! \n Muallif ID raqami -  ".$aaa[$i][0],
                ]); 
        }else{
                bot('senddocument',[   
                'chat_id'=>$chat_id,   
                'document'=>$aaa[$i][1],
                'caption'=>"Muallif ID raqami -  ".$aaa[$i][0]."\n Maxsus raqami - ".$aaa[$i][4],
                ]); 
            }
    
      
}
}

if($mtext == "/qabul"){
    if (tekshir($chat_id)) {
        bot('sendmessage',[   
        'chat_id'=>$chat_id,   
        'text'=>"Сиз қуйидаги мақолаларни юборгансиз.",
        ]); 
        $ikkiaaa=maqolachitahrirlashuchun($chat_id);
        for ($i=0; $i<count($ikkiaaa); $i++){

            if ($ikkiaaa[$i][2] == 1) {
                bot('senddocument',[   
                'chat_id'=>$chat_id,   
                'document'=>$ikkiaaa[$i][1],
                'caption'=>"✅✅✅ Мақола қабул қилинган!"
                ]); 
            } else{
                bot('senddocument',[   
                'chat_id'=>$chat_id,   
                'document'=>$ikkiaaa[$i][1],
                'caption'=>"🧭🧭🧭 кўриб чиқилмоқда"
                ]); 
            }
}


    } else {
        bot('sendmessage',[   
        'chat_id'=>$chat_id,   
        'text'=>"Сиз ✅ «Central Asian Journal of Education and Computer Sciences» илмий журналининг 2-сонига ҳеч қандай мақола юбормадингиз. 😔",
        ]); 
        unlink("qadam/$chat_id.step1");
}

    
}



if($mtext == "Muallif bilan bog'lanish" && $chat_id == $adminId){
  file_put_contents("aloqa/$chat_id.step","bir1");  
  file_put_contents("aloqa/$chat_id.menyu","mom1");
    bot('sendmessage',[   
   'chat_id'=>$chat_id,   
   'text'=>"Maqolachi ID raqamini kiriting.",
   'reply_markup'=>$bekor,
    ]);  
}
if($step == "bir1" && $menyu == "mom1"){
  if($mtext == "Bekor qilish 🙅‍♂️"){        
  bot('sendmessage',[   
  'chat_id'=>$chat_id,   
  'text'=>"Bekor qilindi",   
  'parse_mode'=>"markdown",  
  'reply_markup'=>$adminmenyu,
  ]);
  unlink("aloqa/$chat_id.step"); 
  unlink("aloqa/$chat_id.menyu");  
}else{
    file_put_contents("aloqa/$chat_id.step","bir2");  
    file_put_contents("aloqa/$chat_id.menyu","mom2");
    file_put_contents("aloqa/$chat_id.maqolachi_id", $mtext);
    bot('sendmessage',[   
  'chat_id'=>$chat_id,   
  'text'=>'Matnni kiriting!',   
  'parse_mode'=>"markdown",  
  'reply_markup'=>$bekor,
  ]);
}
}
if($step == "bir2" && $menyu == "mom2"){
  if($mtext == "Bekor qilish 🙅‍♂️"){        
  bot('sendmessage',[   
  'chat_id'=>$chat_id,   
  'text'=>"Bekor qilindi",   
  'parse_mode'=>"markdown",  
  'reply_markup'=>$adminmenyu,
  ]);
  unlink("aloqa/$chat_id.step"); 
  unlink("aloqa/$chat_id.menyu"); 
  unlink("aloqa/$chat_id.maqolachi_id"); 
}else{
   bot('sendmessage',[   
  'chat_id'=>$maqolachi_id,   
  'text'=>$mtext,   
  'parse_mode'=>"markdown",  
  'reply_markup'=>$MaqolaYuborish
  ]);
}
}





/*https://api.telegram.org/bot2006776430:AAE9MnoJLkz1TTHd37SnNKTqNuJjTXKQrns/setWebhook?url=https://cajecs.com/cajecsbot/cajecsbot.php*/
  //.ol($chat_id, $ism)." ".ol($chat_id, $otasiningIsmi)."!!!"
?>