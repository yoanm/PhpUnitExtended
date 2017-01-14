Feature: StrictCoverageListener

  Background:
    Given I use "StrictCoverageListener" phpunit configuration
    And I enable coverage

  Scenario: Remove coverage for Risky test with output
    Given I use "risky-output-with-coverage" group
    When I run phpunit
    And I should have the following regexp "#Lines:\s+0\.00%#"
