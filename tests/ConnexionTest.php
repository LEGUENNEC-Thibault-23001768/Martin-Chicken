<?php

use PHPUnit\Framework\TestCase;

class ConnexionTest extends TestCase
{
    public function testExecuteSelectQuery()
    {
        $result = Connexion::execute("SELECT 1");
        $this->assertNotEmpty($result);
        $this->assertEquals(1, $result[0][1]);
    }

    public function testInsertQuery()
    {
        Connexion::execute("INSERT INTO test_table (name) VALUES (:name)", ['name' => 'Test']);
        $id = Connexion::lastInsertId();
        $this->assertGreaterThan(0, $id);
    }
}
?>
