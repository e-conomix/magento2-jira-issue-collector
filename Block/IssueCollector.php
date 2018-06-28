<?php

namespace CyberDuck\JiraIssueCollector\Block;

use Magento\Framework\View\Element\Template;

class IssueCollector extends Template
{
    const JIRA_ISSUE_COLLECTOR_FRONTEND_CONFIG_PATH = 'web/jira_issue_collector/frontend';
    const JIRA_ISSUE_COLLECTOR_ADMINHTML_CONFIG_PATH = 'web/jira_issue_collector/adminhtml';
    const JIRA_ISSUE_COLLECTOR_URL_CONFIG_PATH = 'web/jira_issue_collector/url';

    /**
     * Path to template file in theme.
     *
     * @var string
     */
    protected $_template = 'CyberDuck_JiraIssueCollector::issue_collector.phtml';

    /**
     * Find out if the Issue Collector should be rendered.
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function isAllowed()
    {
        if ($this->_appState->getAreaCode() === 'adminhtml') {
            return $this->_scopeConfig->getValue(self::JIRA_ISSUE_COLLECTOR_ADMINHTML_CONFIG_PATH);
        }

        return $this->_scopeConfig->getValue(self::JIRA_ISSUE_COLLECTOR_FRONTEND_CONFIG_PATH);
    }

    /**
     * Simply retrieve what should be the embeded JS URL used from the config.
     *
     * @return mixed|string
     */
    public function getEmbededjsUrl()
    {
        return $this->_scopeConfig->getValue(self::JIRA_ISSUE_COLLECTOR_URL_CONFIG_PATH);
    }

    /**
     * Render block HTML conditionally
     *
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _toHtml()
    {
        if (! $this->isAllowed() || ! filter_var($this->getEmbededjsUrl(), FILTER_VALIDATE_URL)) {
            return '';
        }

        return parent::_toHtml();
    }
}
