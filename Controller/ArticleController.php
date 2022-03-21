<?php

declare(strict_types = 1);

class ArticleController
{   
    private DatabaseManager $database;
    public function __construct()
    {   
        require_once 'config.php';
        require_once 'DatabaseManager.php';	
        $this->database=new DatabaseManager($config['host'], $config['user'], $config['password'], $config['dbname']);
        $this->database->connect();
    }
    public function index()
    {
        // Load all required data
        $articles = $this->getArticles();

        // Load the view
        require 'View/articles/index.php';
    }

    // Note: this function can also be used in a repository - the choice is yours
    private function getArticles()
    {          
        $que="SELECT * FROM articles.articles;";
        $q=$this->database->connection->prepare($que);
        $q->execute();
        // TODO: prepare the database connection
        // Note: you might want to use a re-usable databaseManager class - the choice is yours
        // TODO: fetch all articles as $rawArticles (as a simple array)
        $rawArticles = $q->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];
        foreach ($rawArticles as $rawArticle) {
            // We are converting an article from a "dumb" array to a much more flexible class
            $articles[] = new Article($rawArticle['title'], $rawArticle['id'],$rawArticle['description'], $rawArticle['publish_date']);
        }

        return $articles;
    }

    public function show()
    {
        if(empty($_GET['id']))
        {
            $que="SELECT * FROM articles.articles WHERE id=(select min(id) from articles where id > 0);";
            $q=$this->database->connection->prepare($que);
            $q->execute();
            $rawArticle = $q->fetch(PDO::FETCH_ASSOC);
            
            $article=new Article($rawArticle['title'], $rawArticle['id'],$rawArticle['description'], $rawArticle['publish_date']);

        }else 
        {
            $que="SELECT * FROM articles.articles WHERE id=(select min(id) from articles where id >=  '{$_GET['id']}');";
            $q=$this->database->connection->prepare($que);
            $q->execute();
            $rawArticle = $q->fetch(PDO::FETCH_ASSOC);
            
            $article=new Article($rawArticle['title'], $rawArticle['id'],$rawArticle['description'], $rawArticle['publish_date']);
  
        }
        require "View/articles/show.php";
    }
    public function getNextID($id)
    {   
        $lastID= $this->getLastID();
        $firstID=$this->getFirstID();
        if($id>=$lastID){$id=$firstID-1;}        

        $que="SELECT id FROM articles.articles WHERE id=(select min(id) from articles where id >  '{$id}');";
        $q=$this->database->connection->prepare($que);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC)['id'];
    }

    public function getPreviousID($id)
    {   
        $lastID= $this->getLastID();
        $firstID=$this->getFirstID();
        if($id==$firstID){$id=$lastID+1;}

        $que="SELECT id FROM articles.articles WHERE id=(select max(id) from articles where id <  '{$id}');";
        $q=$this->database->connection->prepare($que);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC)['id'];
    }
    
    private function getLastID()
    {
        $que="SELECT id FROM articles.articles ORDER BY id DESC LIMIT 1;";
        $q=$this->database->connection->prepare($que);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC)['id'];
    }
    private function getFirstID()
    {
        $que="SELECT id FROM articles.articles ORDER BY id LIMIT 1;";
        $q=$this->database->connection->prepare($que);
        $q->execute();
        return $q->fetch(PDO::FETCH_ASSOC)['id'];
    }

}