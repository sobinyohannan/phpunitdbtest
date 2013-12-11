<?php

/**
 * Test cases implementation
 * @author  Jeremy
 * @modified-by Sobin
 * @date 11 Dec 2013
 */
require 'FixtureTestCase.php';

class DbActionTest extends FixtureTestCase {

    public $fixtures = array(
        'blog',
    );
    protected $con;

    public function __construct() {
        $this->con = $this->getConnection()->getConnection();
    }

    /**
     * Sample testcase
     */
    /* function testReadDatabase() {
      $conn = $this->getConnection()->getConnection();

      // fixtures auto loaded, let's read some data
      $query = $conn->query('SELECT * FROM posts');
      $results = $query->fetchAll(PDO::FETCH_COLUMN);
      $this->assertEquals(2, count($results));

      // now delete them
      $conn->query('TRUNCATE posts');

      $query = $conn->query('SELECT * FROM posts');
      $results = $query->fetchAll(PDO::FETCH_COLUMN);
      $this->assertEquals(0, count($results));

      // now reload them
      $ds = $this->getDataSet(array('posts'));
      $this->loadDataSet($ds);

      $query = $conn->query('SELECT * FROM posts');
      $results = $query->fetchAll(PDO::FETCH_COLUMN);
      $this->assertEquals(2, count($results));
      } */

    /**
     * Test cases related with Blog table
     */
    public function testCaseSelectAllBlog() {

        //$conn = $this->getConnection()->getConnection();
        // Asserts if there are 33 rows
        $query = $this->con->query("select * from blog");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals(33, count($result));
    }

    /**
     * Test case : Update a record
     */
    public function testAllRecordsDelete() {

        $query = $this->con->query("delete from blog");

        // Assert the row count now equals 0
        $query = $this->con->query("Select * from blog");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals(0, count($result));
    }

    /**
     * Test case : Database Insertion
     */
    public function testRecordInsertion() {

        // Get the current count of records
        $query = $this->con->query("Select * from blog");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        $prev_count = count($result);

        $title = 'Test' . rand();
        $content = 'Test content' . rand();
        $query = $this->con->query("insert into blog(id,title,content) values(null,'$title','$content')");

        //Assert the current count
        $query = $this->con->query("Select * from blog");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals($prev_count + 1, count($result));
    }

    /**
     * Test case Delete last inserted record
     */
    public function testLastRecordDelete() {

        // Get the current count of records
        $query = $this->con->query("Select * from blog");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        $prev_count = count($result);

        // fetch last id
        $query = $this->con->query("Select id from blog  ORDER BY `id` DESC LIMIT 0,1 ");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $id = $result[0]['id'];
        $query = $this->con->query("delete from blog where id = $id");

        //Assert the current count
        $query = $this->con->query("Select * from blog");
        $result = $query->fetchAll(PDO::FETCH_COLUMN);
        $this->assertEquals($prev_count - 1, count($result));
    }

    /**
     * Test Case : Update a record
     */
    public function testRecordUpdate() {

        $id = 5;
        $title = 'New Title';

        // Update query
        $query = $this->con->query("update blog set title = '$title' where id = $id");

        // Assert the title of this record
        $query = $this->con->query("select * from blog where id = $id");
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        //$this->assertEquals(1, count($result));            
        $this->assertEquals($title, $result[0]['title']);
    }
    
    
    

}
