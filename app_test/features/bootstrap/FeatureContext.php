<?php
namespace Functional\Yoanm\PhpUnitExtended\BehatContext;

use Behat\Behat\Context\Context;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /** @var Process|null */
    private $process = null;

    /**
     * @Given I run :testSuiteName phpunit test-suite
     */
    public function iRunPhpunitTestSuite($testSuiteName, $withCoverage = false)
    {
        $argList = [
            sprintf('%s/%s/vendor/bin/phpunit', __DIR__, '../../..'),
            '--testsuite',
            $testSuiteName,
            '-c',
            sprintf('%s/%s/phpunit.xml', __DIR__, '../..'),
        ];
        if (true === $withCoverage) {
            $argList[] = '--coverage-text';
        }
        $processBuilder = new ProcessBuilder($argList);
        $this->process = $processBuilder->getProcess();

        $this->process->run();
    }

    /**
     * @Given I run :testSuiteName phpunit test-suite with coverage
     */
    public function iRunPhpunitTestSuiteWithCoverage($testSuiteName)
    {
        $this->iRunPhpunitTestSuite($testSuiteName, true);
    }

    /**
     * @Then /^I should have (?P<expectedFailureCount>\d+) failure(s)?$/
     */
    public function iShouldHaveXFailures($expectedFailureCount)
    {
        $output = $this->process->getOutput();

        $failureCount = preg_match_all(sprintf('#There was %s failure#', $expectedFailureCount), $output);
        if ($failureCount != $expectedFailureCount) {
            throw new \Exception(sprintf('Found %d failure, but %d expected', $failureCount, $expectedFailureCount));
        }
    }

    /**
     * @Then I should have a failure containing following message :expectedMessage
     */
    public function iShouldHaveAFailureContainingFollowingMessage($expectedMessage)
    {
        $output = $this->process->getOutput();

        if (!preg_match(sprintf('#%s#', preg_quote($expectedMessage, '#')), $output)) {
            throw new \Exception(sprintf('"%s" not found in : %s', $expectedMessage, $output));
        }
    }
}
