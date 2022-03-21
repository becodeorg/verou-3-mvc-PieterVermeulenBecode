<?php

declare(strict_types=1);

class Article
{
    public string $title;
    public ?string $description;
    public ?string $publishDate;
    public int $id;
    

    public function __construct(string $title, int $id, ?string $description, ?string $publishDate)
    {
        $this->title = $title;
        $this->description = $description;
        $this->publishDate = $publishDate;
        $this->id = $id;
    }

    public function formatPublishDate($format = 'DD-MM-YYYY')
    {
        var_dump($this->publishDate);
        // switch ($format){
        // case 'DD-MM-YYYY':
            
            
        //     break;
        // case 'MM-DD-YYYY':
            
        //     return;
        // case 'YYYY-MM-DD':
        // default:
        //     return
        //     break;
        // }
    }
    
   
}