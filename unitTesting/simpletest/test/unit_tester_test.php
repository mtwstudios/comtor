<?php
// $Id: unit_tester_test.php,v 1.1 2009-04-28 17:58:30 ssigwart Exp $
require_once(dirname(__FILE__) . '/../autorun.php');

class ReferenceForTesting {
}

class TestOfUnitTester extends UnitTestCase {
    
    function testAssertTrueReturnsAssertionAsBoolean() {
        $this->assertTrue($this->assertTrue(true));
    }
    
    function testAssertFalseReturnsAssertionAsBoolean() {
        $this->assertTrue($this->assertFalse(false));
    }
    
    function testAssertEqualReturnsAssertionAsBoolean() {
        $this->assertTrue($this->assertEqual(5, 5));
    }
    
    function testAssertIdenticalReturnsAssertionAsBoolean() {
        $this->assertTrue($this->assertIdentical(5, 5));
    }
    
    function testCoreAssertionsDoNotThrowErrors() {
        $this->assertIsA($this, 'UnitTestCase');
        $this->assertNotA($this, 'WebTestCase');
    }
    
    function testReferenceAssertionOnObjects() {
        $a = &new ReferenceForTesting();
        $b = &$a;
        $this->assertReference($a, $b);
    }
    
    function testReferenceAssertionOnScalars() {
        $a = 25;
        $b = &$a;
        $this->assertReference($a, $b);
    }
    
    function testCloneOnObjects() {
        $a = &new ReferenceForTesting();
        $b = &new ReferenceForTesting();
        $this->assertClone($a, $b);
    }
    
    function testCloneOnScalars() {
        $a = 25;
        $b = 25;
        $this->assertClone($a, $b);
    }
}
?>