<?php
namespace MyProject\Models;

use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */

     public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
   }

   private function underscoreToCamelCase(string $source): string
   {
       return lcfirst(str_replace('_', '', ucwords($source, '_')));
   }

// Запрос на все статьи
   /**
    * @return static[]
    */

   public static function findAll(): array
   {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM ' . static::getTableName() . ' ;', [], static::class);
   }

   abstract protected static function getTableName(): string;

// Получение отдельной статьи по Id
   /**
    * @param int $id 
    * @return static|null
    */
    public static function getById(int $id): ?self{
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM ' . static::getTableName() . ' WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }
// Логига Обновления и Добавления статей
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !==null){
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

// Изменение записи в БД
    private function update(array $mappedProperties): void
    {
        $colums2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $param = ':param'. $index; 
            $colums2params[] = $column . ' = '. $param;
            $params2values[$param] = $value;
            $index++;
    }
    $sql = 'UPDATE '. static::getTableName(). ' SET '. implode(', ', $colums2params).' WHERE id = ' . $this->id;
    
    $db = Db::getInstance();
    $db->query($sql, $params2values, static::class);
    }

// Добавление записи в БД   
    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] =''. $columnName . '';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;

        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon .');' ;

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
    }

// Удаление записи из БД
    public function delete(): void
    {
        $db = Db::getInstance();
        $db->query('DELETE FROM '. static::getTableName() .' WHERE id = :id', [':id' => $this->id]
    );
    $this->id = null;
    }

// private function mapPropertiesToDbFormat
    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
    }
    return $mappedProperties;
    }

// private function camelCaseToUnderscore
    private function camelCaseToUnderscore(string $source): string
    {
     return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

// Метод поиска записи по столбцу
    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM '. static::getTableName().' WHERE '. $columnName .'= :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if ($result === []){
            return null;
        }
        return $result[0];
    }
}
?>