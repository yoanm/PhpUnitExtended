Feature: RiskyToFailedListener
  Check that listener convert risky test into failed test

  Background:
    Given I use "RiskyToFailedListener" phpunit configuration

  Scenario: Risky test with output
    Given I use "risky-output" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyOutputTest::test#"
    Then I should have the following regexp "#Strict mode - No output during test#"
    And I should have the following regexp "#TEST_OUTPUT_DURING_TEST#"

  Scenario: Risky test with coverage overflow
    Given I use "risky-coverage" group
    And I enable coverage
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyCoverageTest::test#"
    Then I should have the following regexp "#Strict mode - Only executed code must be defined with @covers and @uses annotations#"
    And I should have the following regexp "#AppTest\\DefaultClass::notExistingMethod#"

  Scenario: Risky test that do not test anything
    Given I use "risky-test-nothing" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyNothingTest::test#"
    And I should have the following regexp "#No test that do not test anything#"

  Scenario: Risky test that manipulate globals
    Given I use "risky-globals-var" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyGlobalsTest::testGlobalsVar#"
    Then I should have the following regexp "#No global variable manipulation during test#"

  Scenario: Risky test that manipulate globals static attributes
    Given I use "risky-static-att" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyGlobalsTest::testStaticAtt#"
    And I should have the following regexp "#No static attribute manipulation during test#"
