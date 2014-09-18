<?php



class NewsItem{
    
    protected $publish_date;
    protected $title;
    protected $text;
    protected $id;
    
    
    public $writer;


    /**
     * Процедура для создания экземпляра новости
     * @param date $publish_date
     * @param string $title
     * @param string $text
     * @param integer $id 
     */
    
    public function __construct($publish_date,$title,$text,$id) {
        $this->publish_date=$publish_date;
        $this->title=$title;
        $this->text=$text;
        $this->id=$id;
        
        $this->writer= new NewsItemWriter();
    }
    
      public function __call($name,$argument){
        
         $methodname='write'.ucfirst($name);
        if(method_exists($this->writer, $methodname)){
            
            return $this->writer->$methodname($this,$argument);
     
        } else{
            
            throw new Exception('not exists');
        }
        
    }
    
    /**
     * Процедура для создания экземпляра новости
     * @param date $publish_date
     * @param string $title
     * @param string $text
     */
    
    public function getPublishDate(){
        
        return $this->publish_date;
    }
    
   
  
 /**
 * Возвращает нозвание новости с заглавной буквы
 * @return string
 */
  
  public function getTitle(){
      
      return ucfirst($this->title);
  }
 
  
  /**
 * Возвращает нозвание новости с заглавной буквы
 * @return string
 */
  
  public function getText(){
      
      return $this->text;
  }
}

  
    

class NewsItemWriter{
    
    
    const DEFAULT_DATE_FORMAT='H:i:s d.m.Y';
    const DEFAULT_CUT_LENGTH=100;
  /**
     * Процедура для создания вывода новости на экран
     * @param NewsItem $NewsItem
     * @param integer $mode -1 полная новость 2- краткая новость
     * @param string $text
     */
    
    public function writeNewsItem(NewsItem $news,$mode=1){
        
        echo '<p><i>'.$news->getPublishDate().'</i>&nbsp;&nbsp;&nbsp;<b>'.$news->getTitle().'</b></p>';

       if($mode==1){
        

     echo  '<p>'.$news->getText().'</p>';

      echo  '<p><a href="'.PROJECT_PATH.'">к списку новостей</a></p>';
    
    } 
        
        
    if($mode==2){
 
        echo '<p>'.$this->cutText($news->getText()).'</p>';
        echo '<p><a href="'.PROJECT_PATH.'/news/?id='.$news->id.'">подробнее</a></p>';
        echo '<hr>';
        
    } 
    
 
            
            
}

 /**
 * Форматирует дату в требуемый формат
 * @param string $date
 * @param string $format
 * @return string
 */
  function formatDate( $date, $format = self::DEFAULT_DATE_FORMAT){
      
    $timestamp = strtotime($date);
    $formatedDate = date($format, $timestamp); 
    
    return $formatedDate;
  }
  
  /**
 * Выдает первые 2 предложения
 * или обрезает строку до 300 символов
 * @param string $text
 * @param integer $cut_length
 * @return string
 */
  function cutText($text, $cut_length = self::DEFAULT_CUT_LENGTH) {
    $arText = explode('.', $text, 3);
    $str = $arText[0];
    if(isset($arText[1])) {
        $str .= '. ' . $arText[1] . '.'; 
    }
    
    if( strlen($str) < $cut_length ){
        return $str;
    } else {
        return substr($str, 0, $cut_length) . ' ...';
    }
}

 /**
 * Выдает первые 2 предложения
 * или обрезает строку до 300 символов
 * @param string $text
 * @param integer $cut_length
 * @return string
 */
  
 public function compareDate($newsItem_1, $newsItem_2){
    $date_1 = $newsItem_1->getPublishDate();
    $date_2 = $newsItem_2->getPublishDate();
    
    $timestamp_1 = strtotime($date_1);
    $timestamp_2 = strtotime($date_2);
    
    if( $timestamp_1 === $timestamp_2 ){
        return 0;
    } else {
        return $timestamp_1 < $timestamp_2 ? 1 : -1;
    }    
}
}