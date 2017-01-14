Feature: YoanmTestsStrategyListener
  Check Yoanm Test Strategy compliance

  Background:
    Given I use "YoanmTestsStrategyListener" phpunit configuration

  Scenario: Risky test with output must failed and not count in coverage
    Given I use "risky-output-with-coverage" group
    And I enable coverage
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyOutputTest::test#"
    Then I should have the following regexp "#Strict mode - No output during test#"
    And I should have the following regexp "#TEST_OUTPUT_DURING_TEST#"
    And I should have the following regexp "#Lines:\s+0\.00%#"

  Scenario: Risky test that do not test anything must failed
    Given I use "risky-test-nothing" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyNothingTest::test#"
    And I should have the following regexp "#No test that do not test anything#"

  Scenario: Risky test that manipulate globals var must failed
    Given I use "risky-globals-var" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyGlobalsTest::testGlobalsVar#"
    Then I should have the following regexp "#No global variable manipulation during test#"

  Scenario: Risky test that manipulate globals static attributes must failed
    Given I use "risky-static-att" group
    When I run phpunit
    Then I should have 1 failure
    Then I should have the following regexp "#1\) RiskyGlobalsTest::testStaticAtt#"
    And I should have the following regexp "#No static attribute manipulation during test#"
