Feature: TestStrategyListener

  Scenario: Risky output
    Given I run "risky-output" phpunit test-suite
    Then I should have 1 failure
    Then I should have a failure containing following message "1\) RiskyOutputTest::test"
    Then I should have a failure containing following message "Strict mode - No output during test"
    And I should have a failure containing following message "TEST_OUTPUT_DURING_TEST"

  Scenario: Risky coverage
    Given I run "risky-coverage" phpunit test-suite with coverage
    Then I should have 1 failure
    Then I should have a failure containing following message "1\) RiskyCoverageTest::test"
    Then I should have a failure containing following message "Strict mode - Executed code must be defined with @covers and @uses annotations"
    And I should have a failure containing following message "src/DefaultClass.php:8"

  Scenario: Risky test that do not test anything
    Given I run "risky-nothing" phpunit test-suite
    Then I should have 1 failure
    Then I should have a failure containing following message "1\) RiskyNothingTest::test"
    And I should have a failure containing following message "Strict mode - Risky test"

  Scenario: Risky globals manipulation
    Given I run "risky-globals" phpunit test-suite
    Then I should have 1 failure
    Then I should have a failure containing following message "1\) RiskyGlobalsTest::test"
    Then I should have a failure containing following message "Strict mode - Risky test"
