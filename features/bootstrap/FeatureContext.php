<?php
namespace Functional\Yoanm\PhpUnitExtended\BehatContext;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{

    /** @var Process|null */
    private $process = null;
    /** @var string|null */
    private $configurationName = null;
    /** @var string[] */
    private $groupNameList = [];
    /** @var bool */
    private $withCoverage = false;

    /**
     * @Given I use :configurationName phpunit configuration
     */
    public function iUsePhpunitConfiguration($configurationName)
    {
        $this->configurationName = $configurationName;
    }

    /**
     * @Given I use :groupName group
     */
    public function iUseGroup($groupName)
    {
        $this->groupNameList[] = $groupName;
    }

    /**
     * @Given I enable coverage
     */
    public function iEnableCoverage()
    {
        $this->withCoverage = true;
    }

    /**
     * @Given I run phpunit
     */
    public function iRunPhpunitTestSuite()
    {
        $baseArgList = [
            sprintf('%s/%s/vendor/bin/phpunit', __DIR__, '../..')
        ];
        $argList = array_merge($baseArgList, $this->getCustomConfig());
        $processBuilder = new ProcessBuilder($argList);

        $this->process = $processBuilder->getProcess();

        var_dump($this->process->getCommandLine());

        $this->process->run();
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
     * @Then I should have the following regexp :regexp
     */
    public function iShouldHaveAFailureContainingFollowingMessage($regexp)
    {
        $output = $this->process->getOutput();

        if (!preg_match($regexp, $output)) {
            throw new \Exception(sprintf('"%s" not found in : %s', $regexp, $output));
        }
    }

    /**
     * @Then :className should not be covered
     */
    public function shouldNotBeCovered($className)
    {
        throw new PendingException();
    }

    /**
     * @return array
     */
    protected function getCustomConfig()
    {
        $config = [];

        if (null !== $this->configurationName) {
            $config[] = '-c';
            $config[] = sprintf('phpunitConfig/%s.phpunit.xml', $this->configurationName);
        }

        foreach ($this->groupNameList as $groupName) {
            $config[] = '--group';
            $config[] = $groupName;
        }

        if (true === $this->withCoverage) {
            $config[] = '--coverage-text';
        }

        return $config;
    }
}
