<?php
//на задание ушло ~4 часов
class Farm
{
    public $animals = array();
    
    public function getAnimalCount($animal_type)
    {
        $animalCount = 0;
        foreach ($this->animals as $animal) {
            if ($animal instanceof $animal_type) {
                $animalCount++;
            }
        }
        return $animalCount;
    }

    public function addAnimal($animal)
    {
        array_push($this->animals, $animal);
    }

    public function removeProducedGoods($animal_type)
    {
        $producedCount = 0;
        foreach ($this->animals as $animal) {
            if ($animal instanceof $animal_type) {
                $producedCount += $animal->productCount;
                $animal->productCount = 0;
                //можно еще добавить глобальные переменные producedMilk и producedEggs куда будем складывать продукты
            }
        }
        return $producedCount;
    }
}

class Animal
{
    public $id;
    public $productCount = 0;

    function __construct()
    {
        $this->id = getId();
    }
}

class Cow extends Animal
{
    function produce()
    {
        $this->productCount += rand(8, 12);
    }
}

class Chicken extends Animal
{
    function produce()
    {
        $this->productCount += rand(0, 1);
    }
}
//дает случайный id
function getId()
{
    $str = rand();
    $result = md5($str);
    return $result;
}
//добавить животных по типу (тип должен совпадать с названием класса)
function addAnimals($farm, $count, $animal_type)
{
    for ($x = 0; $x < $count; $x++) {
        $farm->addAnimal(new $animal_type());
    }
}
//показать имеющихся животных по типу (тип должен совпадать с названием класса)
function showAnimals($farm, $animal_type)
{
    echo $animal_type . ': ' . $farm->getAnimalCount($animal_type);
    echo PHP_EOL;
}
//произвести продукт
function produce($farm, $days)
{
    for ($x = 0; $x < $days; $x++) {
        foreach ($farm->animals as $animal) {
            $animal->produce();
        }
    }
}

function showProduced($farm, $animal_type)
{
    echo $animal_type . 's produced: ' . $farm->removeProducedGoods($animal_type) . ' l.';
    echo PHP_EOL;
}


//MAIN
function main()
{
    $farm = new Farm();

    //Система должна добавить животных в хлев (10 коров и 20 кур).
    addAnimals($farm, 10, 'Cow');
    addAnimals($farm, 20, 'Chicken');

    // Вывести на экран информацию о количестве каждого типа животных на ферме.
    showAnimals($farm, 'Cow');
    showAnimals($farm, 'Chicken');

    // 7 раз (неделю) произвести сбор продукции (подоить коров и собрать яйца у кур).
    produce($farm, 7);

    // Вывести на экран общее кол-во собранных за неделю шт. яиц и литров молока.
    showProduced($farm, 'Cow');
    showProduced($farm, 'Chicken');

    // Добавить на ферму ещё 5 кур и 1 корову (съездили на рынок, купили животных).
    addAnimals($farm, 5, 'Chicken');
    addAnimals($farm, 1, 'Cow');

    // Снова вывести информацию о количестве каждого типа животных на ферме.
    showAnimals($farm, 'Cow');
    showAnimals($farm, 'Chicken');

    // Снова 7 раз (неделю) производим сбор продукции и выводим результат на экран.
    produce($farm, 7);
    showProduced($farm, 'Cow');
    showProduced($farm, 'Chicken');
}

main();
