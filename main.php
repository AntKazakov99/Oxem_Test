<?php

/**
 * Прототип хлева
 */
class Prototype
{
    /**
     * Коллекция животных
     *
     * @var array
     */
    private $animals = [];

    /**
     * Общее число собранного молока
     *
     * @var int
     */
    private $milkSummary;

    /**
     * Общее число собранных яиц
     *
     * @var int
     */
    private $eggsSummary;

    /**
     * Добавление нового животного в хлев
     * 
     * @param Animal $newAnimal
     * добавляемое животное
     * @return bool
     * true - если успешно добавлено, false - если нет
     */ 
    public function AddAnimal($newAnimal)
    {
        $this->animals[] = $newAnimal;
    }

    /**
     * Сбор всей продукции
     *
     * @return array
     * Ассоциативный массив который содержит информацию о собранных
     * 
     */ 
    public function CollectAll()
    {
        $milk = 0;
        $eggs = 0;

        foreach ($this->animals as $value)
        {
            $collectedRes = $value->CollectResource();

            switch ($collectedRes["resource"]) {
                case 'milk':
                    $milk += $collectedRes["count"];
                    break;

                case 'eggs':
                    $eggs += $collectedRes["count"];
                
            }
        }

        $this->milkSummary += $milk;
        $this->eggsSummary += $eggs;

        return ["milk" => $milk, "eggs" => $eggs];

    }

    public function getResourcesSummaryCount()
    {
        return ["milk" => $this->milkSummary, "eggs" => $this->eggsSummary];
    }

}

/**
 * Животное
 */
class Animal
{

    // id последнего животного
    private static $lastId = 0;

    // id животного
    private $id;

    function __construct()
    {
        $this->id =  ++self::$lastId;
    }

    // Получение id животного
    public function GetId()
    {
        return $this->id;
    }

    public function CollectResource()
    {
        return ["resource" => "none", "count" =>  -1];
    }

}

/**
 * Курица
 */
class Chicken extends Animal
{
    private const resource = "eggs";

    private const minResource = 0;

    private const maxResource = 1;
    
    function __construct()
    {
        parent::__construct();
    }

    public function CollectResource()
    {
        return ["resource" => self::resource, "count" => rand(self::minResource, self::maxResource)];
    }

}

/**
 * Корова
 */
class Cow extends Animal
{
    private const resource = "milk";

    private const minResource = 8;

    private const maxResource = 12;
    
    function __construct()
    {
        parent::__construct();
    }

    public function CollectResource()
    {
        return ["resource" => self::resource, "count" => rand(self::minResource, self::maxResource)];
    }

}

$prototype = new Prototype();

for ($i=0; $i < 10; $i++) { 
    $prototype->AddAnimal(new Cow());
}

for ($i=0; $i < 20; $i++) {
    $prototype->AddAnimal(new Chicken());
}


echo "Collect resource:<br>";
var_dump($prototype->CollectAll());
echo "<br>";
var_dump($prototype->CollectAll());
echo "<br>";
echo "Resources summary count:<br>";
var_dump($prototype->getResourcesSummaryCount());


?>
