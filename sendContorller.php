<?php 
    $Method = $_POST['func']??'0';
    $dealData  =  $_POST['dealData']??'';

    switch ($Method) {
        case 1:
            json_encode(newDeal($dealData), JSON_UNESCAPED_UNICODE);
            break;
    };

    // Функция для открытия юрл к битрикс24
        function openCurl_ToB24($type, $data){
            //Параметры
            $ApiParams = array(
                'urlApiParams' => 'https://b24-ue6r8b.bitrix24.ru/rest/1/08h8qk13e0a2syr5/' . $type,
                'hbqData' => http_build_query($data)
            );
            // Открытие соединения по ссылке и отправка
                $urlInit = curl_init();
                curl_setopt_array($urlInit, array(
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $ApiParams['urlApiParams'],
                    CURLOPT_POSTFIELDS => $ApiParams['hbqData'],
                ));
                $results = curl_exec($urlInit);
                curl_close($urlInit);
            // Возврат ответа от работы вебхука
                return json_decode($results, 1);
        };
    // Функция для отправки параметров новой сделки
        function newDeal($dealData){
            $newDealData = openCurl_ToB24('crm.deal.add', [
                'fields' => [
                    'TITLE' => 'Тестовая сделка c фирмой '. $dealData['firm'] .' вебхука от '.$dealData['creator'],
                    'STAGE-ID' => 'NEW',
                    "BEGINDATE" => strval(Date('Y-m-d\TH:i:sP')),
			        "CLOSEDATE" => strval(Date('Y-m-d\TH:i:sP', strtotime("+".$dealData['ttl']." days")))],	
                'params' => [
                    'REGISTER_SONET_EVENT' => 'Y'
                ]
                ]);
            return $newDealData;
        };
?>