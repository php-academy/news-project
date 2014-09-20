<?php
$news_data = array(
    new NewsItem("2014-09-05 14:25:00", "У самого синего моря", "Осень в Новосибирске началась с небывалого падения 
            цен на путевки — листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
    new NewsItem("2014-09-05 15:25:00", "У самого синего моря 2", "Осень в Новосибирске началась. C небывалого падения 
            цен на путевки. Листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
    new NewsItem("2014-09-05 13:25:00", "У самого синего моря 3", "Осень в Новосибирске началась. C небывалого падения 
            цен на путевки. Листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
    new NewsItem("2014-09-04 13:25:00", "У самого синего моря 5", "Осень в Новосибирске началась. C небывалого падения 
            цен на путевки. Листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
    new NewsItem("2014-09-03 13:25:00", "У самого ", "Осень в Новосибирске началась. C небывалого падения 
            цен на путевки. Листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
    new NewsItem("2014-09-02 13:25:00", "У самого синего моря 100500", "Осень в Новосибирске началась. C небывалого падения 
            цен на путевки. Листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
    new NewsItem("2014-09-01 13:25:00", "Типа первая новость", "Осень в Новосибирске началась. C небывалого падения 
            цен на путевки. Листья еще не осыпались, а стоимость отдыха 
            в Европе и Юго-Восточной Азии поползла вниз. Отпускников напугали 
            банкротства компаний и нестабильная ситуация в экономике. 
            Чтобы вернуть клиентов, туроператоры работают себе в убыток, 
            но копеечные туры еще больше отпугивают покупателей."
    ),
);

$cmp_date = function($news_element_1, $news_element_2){
    $date_1 = $news_element_1->publishDate;
    $date_2 = $news_element_2->publishDate;
    
    $timestamp_1 = strtotime($date_1);
    $timestamp_2 = strtotime($date_2);
    
    if( $timestamp_1 === $timestamp_2 ){
        return 0;
    } else {
        return $timestamp_1 < $timestamp_2 ? 1 : -1;
    }    
};
uasort($news_data, $cmp_date);
return $news_data;